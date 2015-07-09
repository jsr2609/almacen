<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Entradas;
use AppBundle\Form\EntradasType;
use AppBundle\Event\EntradasEvent;
use AppBundle\EntradasEvents;
use AppBundle\Form\DatosPedidoType;

/**
 * Entradas controller.
 *
 */
class EntradasController extends Controller
{

    /**
     * Lists all Entradas entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Entradas')->findAll();
        
    

        return $this->render('::/Admin/Entradas/index.html.twig', array(
            'entities' => $entities,
            'entradaTipos' => Entradas::$entradaTipos,
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
            array('db' => 'pedidoNumero', 'dt' => 2),
            array('db' => 'facturaNumero', 'dt' => 3),
            array('db' => 'tipoEntrada', 'dt' => 4,
                'formatter' => function($d, $record) {
                    return Entradas::$entradaTipos[$d];
                }
            ),
            
        );
        $dtManager = $this->get('ssa_utilidades.dataTables');
        $entradasManager = $this->get('app.entradas');
        $ejerciciosManager = $this->get('app.ejercicios');
        $ejercicio = $ejerciciosManager->buscarPorAlmacenYPeriodo(null, "ecs.id");
        $datos = $entradasManager->obtenerRegistrosDT($ejercicio['id'], $dtManager, 'AppBundle:VwEntradas', 
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
        $entity = new Entradas();
        $form = $this->createCreateForm($entity);
        //die(var_export($entity->getPrograma()));
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            //Ejecutando eventos entradas.submitted
            $entradasEvent = new EntradasEvent($entity);
            $entradasEvent = $this->container->get('event_dispatcher')->dispatch(EntradasEvents::SUBMITTED, $entradasEvent);
            
            if ($entradasEvent->isPropagationStopped()) {
                $this->addCommentToFlashBag('smtc_error', 'No se ha podido crear el comentario', $comment);
            }
            
            $em->persist($entity);
            $em->flush();
            $this->addFlash('success', "La entrada se creo satisfactoriamente, agregue los artículos necesarios.");
            return $this->redirect($this->generateUrl('admin_entradadetalles', array('id' => $entity->getId())));
            
        }

        return $this->render('::/Admin/Entradas/new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Entradas entity.
     *
     * @param Entradas $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Entradas $entity)
    {
        $form = $this->createForm(new EntradasType(), $entity, array(
            'action' => $this->generateUrl('admin_entradas_create'),
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
     * Displays a form to create a new Entradas entity.
     *
     */
    public function newAction()
    {
        $entity = new Entradas();
        $form   = $this->createCreateForm($entity);

        return $this->render('::/Admin/Entradas/new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Entradas entity.
     *
     */
    public function showAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $id = $request->query->get('entradaId');
        
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('AppBundle:Entradas')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Entradas entity.');
            }

            $deleteForm = $this->createDeleteForm($id);

            $html = $this->renderView('::/Admin/Entradas/show.html.twig', array(
                'entity'      => $entity,
                'delete_form' => $deleteForm->createView(),
            ));
            
            $data = array('code' => 200, 'html' => $html, 'message' => '');
            $response = new JsonResponse($data);
            return $response;
        }
    }

    /**
     * Displays a form to edit an existing Entradas entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Entradas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entradas entity.');
        }
        
        $entradasManager = $this->get('app.entradas');
        $editable = $entradasManager->comprobarEdicion($entity);
        
        if(!$editable['editable']) {
            $this->addFlash("info", $editable['mensaje']);
            return $this->redirect($this->generateUrl('admin_entradas_mostrar_con_articulos', array(
                'id' => $entity->getId(),
            )));
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('::/Admin/Entradas/edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Entradas entity.
    *
    * @param Entradas $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Entradas $entity)
    {
        $form = $this->createForm(new EntradasType(), $entity, array(
            'action' => $this->generateUrl('admin_entradas_update', array('id' => $entity->getId())),
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
     * Edits an existing Entradas entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Entradas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entradas entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_entradas_edit', array('id' => $id)));
        }

        return $this->render('::/Admin/Entradas/edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Entradas entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Entradas')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Entradas entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_entradas'));
    }

    /**
     * Creates a form to delete a Entradas entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_entradas_delete', array('id' => $id)))
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
        $entity = $em->getRepository('AppBundle:Entradas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entradas entity.');
        }
        
        $ejerciciosManager = $this->get('app.ejercicios');
        $iva = $ejerciciosManager->obtenerIVAPorAlmacenYPeriodo();
        $detallesManager = $this->get('app.entrada_detalles');
        $detalles = $detallesManager->listaArticulosPorEntrada($entity->getId(), $iva);
        
        return $this->render('Admin/Entradas/consultar_con_articulos.html.twig', array(
            'entity' => $entity,
            'detalles' => $detalles,
        ));
    }
    
    public function pdfAction(Request $request, $id)
    {
        $tcpdfManager = $this->get('white_october.tcpdf');
        
        $pdf = $tcpdfManager->create(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT);
        $entradasManager = $this->get('app.entradas');
        $select = "ets, partial pgs.{id, clave, nombre}, partial pvs.{id, rfc, nombre},partial ecs.{id, iva}, ams";
        $entrada = $entradasManager->buscar($id, $select, false, 'HYDRATE_ARRAY');
        
        $pdf = $entradasManager->generarPDF($pdf, $entrada);
        
        $pdf->output('entrada.pdf', 'D');
    }
    
    private function addFlash($type, $message) {
        
        $this->getRequest()->getSession()->getFlashBag()->add(
            $type,
            $message
        );
    }
    
    public function crearDePedidoFormAction(Request $request)
    {
        $form = $this->createForm(new DatosPedidoType());
        return $this->render('Admin/Entradas/crear_de_pedido_form.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function procesarCrearDePedidoAction(Request $request)
    {
        
    }
}
