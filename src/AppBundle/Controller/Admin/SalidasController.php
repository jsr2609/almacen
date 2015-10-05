<?php
namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\Salidas;
use AppBundle\Entity\Entradas;
use AppBundle\Entity\SalidaDetalles;
use AppBundle\Form\SalidasType;
use AppBundle\Repository\EntradasRepository;
use AppBundle\PDF\BajaTCPDF;
use AppBundle\Event\SalidasEvent;
use AppBundle\SalidasEvents;


/**
 * Salidas controller.
 *
 * @author jsr by DTD
 */
class SalidasController extends Controller
{

    /**
     * Lists all Salidas entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Salidas')->findAll();
        
        return $this->render('::/Admin/Salidas/index.html.twig', array(
            'entities' => $entities,
            'salidasTipos' => Salidas::$salidasTipos,
        ));
    }
   
     /**
     * Lists all Entradas entities ajax.
     *
     */
    public function indexAjaxAction(Request $request)
    {
        $columnas = array(
            array('db' => 'folio', 'dt' => 0),
            array('db' => 'fecha', 'dt' => 1,
                'formatter' => function(\DateTime $d, $record) {
                    return $d->format('d/m/Y');
                }
            ),
            array('db' => 'nombreQuienRecibe', 'dt' => 2),
            array('db' => 'tipoCompra', 'dt' => 3,
                'formatter' => function($d, $record) {
                    return Salidas::$salidasTipos[$d];
                }
            ),
            
        );
        $dtManager = $this->get('ssa_utilidades.dataTables');
        $salidasManager = $this->get('app.salidas');
        $ejerciciosManager = $this->get('app.ejercicios');
        $ejercicio = $ejerciciosManager->buscarPorAlmacenYPeriodo(null,"ecs.id");
        
        $datos = $salidasManager->obtenerRegistrosDT($ejercicio['id'], $dtManager, 'AppBundle:VwSalidas', 
            $request->query->all(), $columnas
        );
        
        
        $respuesta = new JSONResponse($datos);
               
        
        return $respuesta;
    }
    /**
     * Creates a new Entradas entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Salidas();
        $form = $this->createCreateForm($entity);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            //Ejecutando eventos salidas.submitted
            $salidasEvent = new SalidasEvent($entity);
            $salidasEvent = $this->container->get('event_dispatcher')->dispatch(SalidasEvents::SUBMITTED, $salidasEvent);
            
            if ($salidasEvent->isPropagationStopped()) {
                $this->addCommentToFlashBag('smtc_error', 'No se ha podido crear el comentario', $comment);
            }
            
            $em->persist($entity);
            $em->flush();
            
            if($form->getData()->getTipoEntrada() == 1){
                $this->addFlash('success', "La Salida se creo satisfactoriamente, seleccione la Entrada.");
                return $this->redirect($this->generateUrl('admin_salidadetallesDirecta', array('id' => $entity->getId())));
            }
            
            $this->addFlash('success', "La Salida se creo satisfactoriamente, agregue los artículos necesarios.");
            return $this->redirect($this->generateUrl('admin_salidadetalles', array('id' => $entity->getId())));
            
        }
        
        return $this->render('::/Admin/Salidas/new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Salidas entity.
     *
     * @param Salidas $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Salidas $entity)
    {
        $form = $this->createForm(new SalidasType(), $entity, array(
            'action' => $this->generateUrl('admin_salidas_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Continuar',
            'attr' => array('class' => 'btn-primary'),
            'icon' => 'circle-arrow-right',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Salidas entity.
     *
     */
    public function newAction()
    {
        $entity = new Salidas();
        $form   = $this->createCreateForm($entity);

        return $this->render('::/Admin/Salidas/new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Salidas entity.
     *
     */
    public function showAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $id = $request->query->get('salidaId');
        
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('AppBundle:Salidas')->find($id);
            
            $salidasManager = $this->get('app.salidas');
            $editable = $salidasManager->comprobarEdicion($entity);
            
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Salidas entity.');
            }

            $deleteForm = $this->createDeleteForm($id);

            $html = $this->renderView('::/Admin/Salidas/show.html.twig', array(
                'entity'      => $entity,
                'salidasTipos' => Salidas::$salidasTipos,
                'delete_form' => $deleteForm->createView(),
                'editable'    => $editable['editable']
            ));
            
            $data = array('code' => 200, 'html' => $html, 'message' => '');
            $response = new JsonResponse($data);
            return $response;
        }
    }

    /**
     * Displays a form to edit an existing Salidas entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Salidas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Salidas entity.');
        }
        
        $salidasManager = $this->get('app.salidas');
        $editable = $salidasManager->comprobarEdicion($entity);
        
        if(!$editable['editable']) {
            $this->addFlash("info", $editable['mensaje']);
            return $this->redirect($this->generateUrl('admin_salidas_mostrar_con_articulos', array(
                'id' => $entity->getId(),
            )));
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('::/Admin/Salidas/edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Salidas entity.
    *
    * @param Salidas $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Salidas $entity)
    {
        $form = $this->createForm(new SalidasType(), $entity, array(
            'action' => $this->generateUrl('admin_salidas_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Actualizar',
            'attr' => array('class' => 'btn-primary'),
            'icon' => 'floppy-disk',
        ));

        return $form;
    }
    /**
     * Edits an existing Salidas entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Salidas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Salidas entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_salidas_edit', array('id' => $id)));
        }

        return $this->render('::/Admin/Salidas/edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Salidas entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Salidas')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Salidas entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_salidas'));
    }

    /**
     * Creates a form to delete a Salidas entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_salidas_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Eliminar',
                'attr' => array('class' => 'btn-danger'),
                'icon' => 'trash',
            ))
            ->getForm()
        ;
    }
    
    public function  mostrarConArticulosAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Salidas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Salidas entity.');
        }
        
        $ejerciciosManager = $this->get('app.ejercicios');
        $iva = $ejerciciosManager->obtenerIVAPorAlmacenYPeriodo();
        $detallesManager = $this->get('app.salida_detalles');
        $detalles = $detallesManager->listaArticulosPorSalida($entity->getId(), $iva);
        
        return $this->render('Admin/Salidas/consultar_con_articulos.html.twig', array(
            'entity' => $entity,
            'detalles' => $detalles,
        ));
    }
    
    public function pdfAction(Request $request, $id)
    {
        
        $pdf = new BajaTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT);
        $salidasManager = $this->get('app.salidas');
        $select = "sls, partial pgs.{id, clave, nombre}, partial ecs.{id, iva}, ams, dts";
        $salida = $salidasManager->buscar($id, $select, false, 'HYDRATE_ARRAY');
        
        $pdf = $salidasManager->generarPDF($pdf, $salida);
        $pdf->output('salida.pdf', 'D');
      
    }
    
    
    /* Funciones Para la busqueda de Entradas */
     
    public function popupBuscarEntradaAction(Request $request)
    {
        $acciones = $request->query->get('acciones');
        $salidaId = $request->query->get('salidaId');
        $articuloClave = $request->query->get('articulo');
        $em = $this->getDoctrine()->getManager();
        
        $salida = $em->getRepository('AppBundle:Salidas')->find($salidaId);
        
        if(empty($articuloClave)){
            $entradas = $em->getRepository("AppBundle:Entradas")->recuperarListaEntradasDirectas($salida->getPrograma()->getId());
        }else{
            $entradas = $em->getRepository("AppBundle:Entradas")->recuperarListaEntradas($salida->getPrograma()->getId(), $articuloClave);
        }
        
        
        
        $html = $this->renderView('/Admin/Salidas/popup_buscar_entrada.html.twig', array(
            'acciones' => $acciones,
            'entradas' => $entradas,
            'salida'   => $salidaId,
        ));
        
        
        $data = array('code' => 200, 'html' => $html, 'message' => 'El proceso se realizó correctamente');
        $response = new JsonResponse($data);
        return $response;
    }
    
    public function buscarEntradaAjaxAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $campo = $request->query->get('campo');            
            $valor = $request->query->get('valor');
            $campo = ($campo === NULL) ? 'clave' : $campo;
            $repository = $this->getDoctrine()->getManager()->getRepository("AppBundle:Programas");
            $programa = $repository->findOneBy(array(
                $campo => $valor
            ));
            
            if(!$programa) {
                $code = 500;
                $message = "El programa $valor no existe";
                $datosPrograma = null;
            } else {
                $code = 200;
                $datosPrograma = array(
                    'id' => $programa->getId(), 
                    'clave' => $programa->getClave(),
                    'nombre' => $programa->getNombre(),
                );
                $message = null;
            }
            
            $data = array(
                'code' => $code,
                'programa' => $datosPrograma,
                'message' => $message,
            );
            
            $response = new JsonResponse($data);
            
            return $response;        
        }
    }
}
