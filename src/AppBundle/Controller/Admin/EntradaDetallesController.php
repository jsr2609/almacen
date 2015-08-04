<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\EntradaDetalles;
use AppBundle\Form\EntradaDetallesType;
use SSA\UtilidadesBundle\Helper\Helpers;

/**
 * EntradaDetalles controller.
 *
 */
class EntradaDetallesController extends Controller
{

    /**
     * Lists all EntradaDetalles entities.
     *
     */
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entradasManager = $this->get('app.entradas');
        $entrada = $entradasManager->buscar($id);
        
        $ejerciciosManager = $this->get('app.ejercicios');
        $iva = $ejerciciosManager->obtenerIVAPorAlmacenYPeriodo();
        $adquisicionesManager = $this->get('app.adquisiciones');
        $pedido = $adquisicionesManager->obtenerPedido($entrada->getPedidoNumero(), $entrada->getCompra(), $entrada->getAnioEjercicio());
        $detallesManager = $this->get('app.entrada_detalles');
        $entities = $detallesManager->listaArticulosPorEntrada($entrada->getId(), $iva, $adquisicionesManager);
                
        return $this->render('/Admin/EntradaDetalles/index.html.twig', array(
            'entities' => $entities,
            'entrada' => $entrada,
            'pedido' => $pedido,
        ));
    }
    /**
     * Creates a new EntradaDetalles entity.
     *
     */
    public function createAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $entity = new EntradaDetalles();
            $form = $this->createCreateForm($entity);
            $form->handleRequest($request);

            if ($form->isValid()) {
                $existenciasManager = $this->get('app.existencias');
                $em = $this->getDoctrine()->getManager();            
                
                $ejerciciosManager = $this->get('app.ejercicios');
                $ejercicio = $ejerciciosManager->buscarPorAlmacenYPeriodo(null, 'ecs.iva, ecs.tipoInventario', 'HYDRATE_ARRAY');
                //Iniciando la transacción para crear el detalle y aumentar la existencia
                //Consultar http://doctrine-orm.readthedocs.org/en/latest/reference/transactions-and-concurrency.html#approach-2-explicitly
                $em->getConnection()->beginTransaction();
                
                try
                {    
                    $em->persist($entity);
                    $existenciasManager->aumentar($entity->getArticulo(), 
                        $entity->getEntrada()->getPrograma(), 
                        $entity->getCantidad(), 
                        $entity->getPrecio(),
                        $ejercicio,
                        $entity->getAplicaIva()
                    );
                    
                    $em->flush();
                    $em->getConnection()->commit();
                    
                } catch (Exception $e) {
                    $em->getConnection()->rollback();
                    throw $e;
                } //Fin transacción
                
                $entradaDetallesManager = $this->get('app.entrada_detalles');
                $precioNuevo = $entradaDetallesManager->calcularPrecio($entity->getPrecio(), $ejercicio['iva'], $entity->getAplicaIva());
                $total = round($precioNuevo * $entity->getCantidad(), 2);
                $btnEditar =  '<button type="button" detalle-id="'.$entity->getId().'" 
                    class="btn btn-xs btn-primary btn-editar-articulo" data-toggle="tooltip" 
                    title="Editar"> <i class="fa fa-edit fa-fw"></i></button>';  
                $registro = array(
                    'clave' => $entity->getArticulo()->getClave(),
                    'nombre' => Helpers::getSubString($entity->getArticulo()->getNombre()),
                    'cantidad' => number_format($entity->getCantidad(), 0, '.', ','),
                    'precio' => number_format($precioNuevo, 2, '.', ','),
                    'total' => number_format($total, 2, '.', ','),
                    'btn_editar' => $btnEditar,
                );
                $data = array('code' => 200, 'html' => '', 
                    'message' => 'El artículo se agrego correctamente.',
                    'registro' => $registro,
                );
            } else {
                $data = array('code' => 500, 'html' => '', 'message' => 'Se encontraron errores al procesar el formulario.');
            }
            
            
            $response = new JsonResponse($data);
            return $response;
            
        }
        

        return $this->render('/Admin/EntradaDetalles/new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a EntradaDetalles entity.
     *
     * @param EntradaDetalles $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(EntradaDetalles $entity)
    {
        $form = $this->createForm(new EntradaDetallesType(), $entity, array(
            'action' => $this->generateUrl('admin_entradadetalles_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Guardar',
            'attr' => array('class' => 'btn-primary'),
            'icon' => 'floppy-disk'
        ));

        return $form;
    }

    /**
     * Displays a form to create a new EntradaDetalles entity.
     *
     */
    public function newAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $entity = new EntradaDetalles();
            $entradaId = $request->query->get('entradaId');
            $em = $this->getDoctrine()->getManager();
            $entrada = $em->getRepository("AppBundle:Entradas")->find($entradaId);
            $entity->setEntrada($entrada);
            $form = $this->createCreateForm($entity);

            $html = $this->renderView('/Admin/EntradaDetalles/new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView(),
            ));
            
            $data = array('code' => 200, 'html' => $html, 'message' => 'Correcto');
            $response = new JsonResponse($data);
            return $response;
        }
    }

    /**
     * Finds and displays a EntradaDetalles entity.
     *
     */
    public function showAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $id = $request->query->get('detalleId');
            
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('AppBundle:EntradaDetalles')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EntradaDetalles entity.');
            }
            
            $html = $this->renderView('/Admin/EntradaDetalles/show.html.twig', array(
                'entity'      => $entity,
            ));
            
            $data = array('code' => 200, 'html' => $html, 'message' => '');
            $response = new JsonResponse($data);
            return $response;
        }
    }

    /**
     * Displays a form to edit an existing EntradaDetalles entity.
     *
     */
    public function editAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $detalleId = $request->query->get('detalleId');
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('AppBundle:EntradaDetalles')->find($detalleId);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EntradaDetalles entity.');
            }
            $cantidad = $em->getRepository("AppBundle:EntradaDetalles")->contarEnSalidas($detalleId);
            if($cantidad > 0) {
                /**
                return $this->forward('AppBundle:Admin/EntradaDetalles:show', array(), array(
                    'detalleId' => $detalleId,
                ));**/
                $this->get('ssa_utilidades.base')->addFlashMessage("info", "No se puede editar el detalle, ya existen salidas.");
                $html = $this->renderView('/Admin/EntradaDetalles/show.html.twig', array(
                    'entity'      => $entity,
                ));
            } else {
                $editForm = $this->createEditForm($entity);
                $deleteForm = $this->createDeleteForm($detalleId);  
                $html = $this->renderView('/Admin/EntradaDetalles/edit.html.twig', array(
                    'entity'      => $entity,
                    'edit_form'   => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                ));
            }
            
            $data = array('code' => 200, 'html' => $html, 'message' => '');
            $response = new JsonResponse($data);
            return $response;
        }
    }

    /**
    * Creates a form to edit a EntradaDetalles entity.
    *
    * @param EntradaDetalles $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(EntradaDetalles $entity)
    {
        $form = $this->createForm(new EntradaDetallesType(), $entity, array(
            'action' => '',
            'method' => 'PUT',
            'mostrar_campo_articulo' => false,
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar', 'icon' => 'floppy-disk', 'attr' => array('class' => 'btn-primary')));

        return $form;
    }
    /**
     * Edits an existing EntradaDetalles entity.
     *
     */
    public function updateAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $id = $request->request->get('detalleId');
            
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('AppBundle:EntradaDetalles')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EntradaDetalles entity.');
            }
            
            $cantidadActual = $entity->getCantidad();
            $precioActual = $entity->getPrecio();
            $aplicaIvaActual = $entity->getAplicaIva();
            
            $editForm = $this->createEditForm($entity);
            $editForm->handleRequest($request);

            if ($editForm->isValid()) {
                $existenciasManager = $this->get('app.existencias');
                $entradaDetallesManager = $this->get('app.entrada_detalles');
                //Iniciando la transaccion
                // $em instanceof EntityManager
                $ejerciciosManager = $this->get('app.ejercicios');
                $ejercicio = $ejerciciosManager->buscarPorAlmacenYPeriodo(null, 'ecs.iva, ecs.tipoInventario', 'HYDRATE_ARRAY');
                
                $em->getConnection()->beginTransaction(); // suspend auto-commit
                try {
                    $existencia = $existenciasManager->buscar($entity->getArticulo(), $entity->getEntrada()->getPrograma(), false);
                    $entradaDetallesManager->actualizarExistencia(
                        $entity, $cantidadActual, $precioActual, 
                        $ejercicio, $existencia, $aplicaIvaActual
                    );
                    
                    
                    $em->flush();
                    $em->getConnection()->commit();
                } catch (Exception $e) {
                    $em->getConnection()->rollback();
                    throw $e;
                }
                
                $precioNuevo = $entradaDetallesManager->calcularPrecio($entity->getPrecio(), $ejercicio['iva'], $entity->getAplicaIva());
                $totalNuevo = $precioNuevo * $entity->getCantidad();
                
                $registro = array(
                    'precio' => number_format($precioNuevo, 2, '.', ','),
                    'cantidad' => number_format($entity->getCantidad(), 0, '.', ','),
                    'total' => number_format($totalNuevo, 2, '.', ','),
                );
                //Fin de la transaccion
                $data = array('code' => 200, 'html' => '', 
                    'message' => 'El artículo se actualizó correctamente.',
                    'registro' => $registro,
                );
            }
            
            
            $response = new JsonResponse($data);
            return $response;
            
        }
    }
    /**
     * Deletes a EntradaDetalles entity.
     *
     */
    public function deleteAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $detalleId = $request->request->get('detalleId');
            $form = $this->createDeleteForm($detalleId);
            $form->handleRequest($request);
            
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $entity = $em->getRepository('AppBundle:EntradaDetalles')->find($detalleId);

                if (!$entity) {
                    throw $this->createNotFoundException('Unable to find EntradaDetalles entity.');
                }
                
                $existenciasManager = $this->get('app.existencias');
                $ejerciciosManager = $this->get('app.ejercicios');
                $ejercicio = $ejerciciosManager->buscarPorAlmacenYPeriodo(null, 'ecs.iva, ecs.tipoInventario', 'HYDRATE_ARRAY');                
                //Inicio de la transaccion
                // $em instanceof EntityManager
                $em->getConnection()->beginTransaction(); // suspend auto-commit
                try {
                    $em->remove($entity);
                    $existenciasManager->disminuir($entity->getArticulo(), 
                        $entity->getEntrada()->getPrograma(), 
                        $entity->getCantidad(), 
                        $entity->getPrecio(),
                        $ejercicio,
                        $entity->getAplicaIva()
                    );
                    $em->flush();
                    $em->getConnection()->commit();
                } catch (Exception $e) {
                    $em->getConnection()->rollback();
                    throw $e;
                }
                //Fin de la transaccion
                $data = array('code' => 200, 'html' => '', 'message' => 'El artículo se eliminó satisfactoriamente');
                
                
            } else {
                $data = array('code' => 500, 'html' => '', 'message' => 'Se encontraron errores al tratar de eliminar el artículo');
            }

            
            $response = new JsonResponse($data);
            return $response;
        }
        
    }

    /**
     * Creates a form to delete a EntradaDetalles entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        
        $form = $this->createFormBuilder(null, array('attr' => array('id' => 'entrada_detalles_eliminar_type')))
            ->setAction('')
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar', 'icon' => 'trash', 'attr' => array('class' => 'btn-danger')))
            ->getForm()
        ;
        
        return $form;
        
        
    }
    
    public function buscarArticuloAction(Request $request) {
        if($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            
            if($request->query->get('entradaDetalleId') != null){
               $salidaDetalle = $em->getRepository("AppBundle:EntradaDetalles")->find($request->query->get('entradaDetalleId'));
               $html = $this->renderView("/Admin/Articulos/showSD.html.twig", array(
                        'entity' => $salidaDetalle,
                    ));
                    $data = array('code' => 200, 'html' => $html, 'message' => 'Correcto');
            }else{
                $articuloClave = $request->query->get('articuloClave');
                $articulo = $em->getRepository("AppBundle:Articulos")->findOneByClave($articuloClave);
                if(!$articulo) {
                    $data = array('code' => 500, 'html' => "", 
                        'message' => 'No se ha encontrado un articulo con la clave: '.$articuloClave,
                    );
                } else {
                    $html = $this->renderView("/Admin/Articulos/show.html.twig", array(
                        'entity' => $articulo,
                    ));
                    $data = array('code' => 200, 'html' => $html, 'message' => 'Correcto');
                }
            }
            
            
            $response = new JsonResponse($data);
            return $response;
        }
    }
}
