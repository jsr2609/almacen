<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\SalidaDetalles;
use AppBundle\Entity\Entradas;
use AppBundle\Form\SalidaDetallesType;
use SSA\UtilidadesBundle\Helper\Helpers;

/**
 * SalidaDetalles controller.
 *
 */
class SalidaDetallesController extends Controller
{
     /**
     * Lists all SalidaDetalles entities.
     *
     */
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $salidasManager = $this->get('app.salidas');
        $salida = $salidasManager->buscar($id);
        
        $ejerciciosManager = $this->get('app.ejercicios');
        $iva = $ejerciciosManager->obtenerIVAPorAlmacenYPeriodo();
        
        $detallesManager = $this->get('app.salida_detalles');
        $entities = $detallesManager->listaArticulosPorSalida($salida->getId(), $iva);
              
        return $this->render('/Admin/SalidaDetalles/index.html.twig', array(
            'entities' => $entities,
            'salida' => $salida,
        ));
       
    }
    
    
    public function indexDirectaAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $salidasManager = $this->get('app.salidas');
        $salida = $salidasManager->buscar($id);
        $editable = $salidasManager->comprobarEdicion($salida);
        
        $ejerciciosManager = $this->get('app.ejercicios');
        $iva = $ejerciciosManager->obtenerIVAPorAlmacenYPeriodo();
        
        $detallesManager = $this->get('app.salida_detalles');
        $entities = $detallesManager->listaArticulosPorSalida($salida->getId(), $iva);
              
        return $this->render('/Admin/SalidaDetalles/indexDirecta.html.twig', array(
            'entities' => $entities,
            'salida' => $salida,
            'editable' => $editable['editable']
        ));
       
    }
    
    /**
     * Incluye una Entrada Directa a una Salida Directa.
     *
     */
    public function salidaDirectaAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entradas = $em->getRepository("AppBundle:Entradas")->recuperarListaEntradasDirectas();
        $html = $this->renderView('/Admin/SalidaDetalles/popup_buscar_entrada.html.twig', array(
            'acciones' => $acciones,
            'entradas' => $entradas,
        ));
        
        $data = array('code' => 200, 'html' => $html, 'message' => 'El proceso se realizó correctamente');
        $response = new JsonResponse($data);
        return $response;
    }
    
    public function mostrarEntradaAction(Request $request)
    {
         if($request->isXmlHttpRequest()) {
            $entradaId = $request->query->get('entradaId');
            $salidaId = $request->query->get('salidaId');            
            
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Entradas')->find($entradaId);
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Entradas entity.');
            }

            $ejerciciosManager = $this->get('app.ejercicios');
            $iva = $ejerciciosManager->obtenerIVAPorAlmacenYPeriodo();
            $detallesManager = $this->get('app.entrada_detalles');
            $detalles = $detallesManager->listaArticulosPorEntrada($entity->getId(), $iva);


                 $code = 200;
                 $html = $this->renderView("Admin/SalidaDetalles/consultar_entrada.html.twig", array(
                    'entity' => $entity,
                    'detalles' => $detalles,
                    'salida' => $salidaId,
                 ));
                 $message = "Confirma que la Entrada es la indicada";


            $data = array('code' => $code, 'html' => $html, 'message' => $message);
            $response = new JsonResponse($data);

            return $response;
        }
    }
    
    public function createDirectaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $em->getConnection()->beginTransaction(); // suspend auto-commit
        try {
           $entrada = $em->getRepository('AppBundle:Entradas')->find($request->request->get('entradaId'));
            
           $entradaDetalles = $this ->getDoctrine()
                   ->getRepository('AppBundle:EntradaDetalles')
                   ->findBy(array('entrada' => $entrada->getId()));
           
            $ejerciciosManager = $this->get('app.ejercicios');
            $iva = $ejerciciosManager->obtenerIVAPorAlmacenYPeriodo();
            $articulosManager = $this->get('app.articulos');
            $sdsManager = $this->get('app.salida_detalles');
            $existenciasManager = $this->get('app.existencias');
            
            $ejercicio = $ejerciciosManager->buscarPorAlmacenYPeriodo(null, 'ecs.iva, ecs.tipoInventario', 'HYDRATE_ARRAY');

            $articulosRepository = $em->getRepository("AppBundle:Articulos");
            
            foreach($entradaDetalles as $articuloSalida)
            {
                $salidasDetalle = new SalidaDetalles();
                $salidasDetalle->setActivo(1);
                $salidasDetalle->setArticulo($em->getReference('AppBundle:Articulos',$articuloSalida->getArticulo()->getId()));
                $salidasDetalle->setCantidad($articuloSalida->getCantidad());
                $salidasDetalle->setEntradaDetalle($em->getReference('AppBundle:EntradaDetalles',$articuloSalida->getId()));
                $salidasDetalle->setSalida($em->getReference('AppBundle:Salidas',$request->request->get('salidaId')));
                $em->persist($salidasDetalle);
                
 // Se modifica la Existencia de la Entrada Detalles                   
                $cantidadActual = $articuloSalida->getCantidad();
                $precioActual = $articuloSalida->getPrecio();
                $aplicaIvaActual = $articuloSalida->getAplicaIva();
                
                $existencia = $existenciasManager->buscar($salidasDetalle->getArticulo(), $salidasDetalle->getSalida()->getPrograma(), false);
                
                $sdsManager->actualizarExistencia(
                    $articuloSalida, $cantidadActual, $precioActual, 
                    $ejercicio, $existencia, $aplicaIvaActual
                );
// Termina modifica la Existencia de la Entrada Detalles                
// Se modifica la Existencia del Articulo    
                $articuloObj = $articulosRepository->findOneBy(array('clave' => $articuloSalida->getArticulo()->getClave()));
                $existenciasManager->disminuir($articuloObj, 
                    $salidasDetalle->getSalida()->getPrograma(),
                    $salidasDetalle->getCantidad(), 
                    $salidasDetalle->getEntradaDetalle()->getPrecio(),
                    $ejercicio,
                    $salidasDetalle->getEntradaDetalle()->getAplicaIva()
                );
// Termina modifica la Existencia del Articulo    


            }
            $em->flush();
            $em->getConnection()->commit();
            
            $this->addFlash('success', "La Salida se creo correctamente !!!");
            $data = array('code' => 200, 'message' => 'El proceso se realizó correctamente');
            $response = new JsonResponse($data);
            return $response;
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            throw $e;
        }
        //Fin de la transaccion
            
    }
    
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
                
        $em->getConnection()->beginTransaction(); // suspend auto-commit
        try {
           
            $ejerciciosManager = $this->get('app.ejercicios');
            $iva = $ejerciciosManager->obtenerIVAPorAlmacenYPeriodo();
            $articulosManager = $this->get('app.articulos');
            $sdsManager = $this->get('app.salida_detalles');
            $existenciasManager = $this->get('app.existencias');
            
            $ejercicio = $ejerciciosManager->buscarPorAlmacenYPeriodo(null, 'ecs.iva, ecs.tipoInventario', 'HYDRATE_ARRAY');

            $articulosRepository = $em->getRepository("AppBundle:Articulos");
            
            $salidasDetalle = new SalidaDetalles();
            $form = $this->createCreateForm($salidasDetalle);
            $form->handleRequest($request);

            $salidasDetalle->setActivo(1);
            $salidasDetalle->setSalida($em->getReference('AppBundle:Salidas',$request->request->get('salida')));
            $em->persist($salidasDetalle);
            
            $articuloSalida = $form->getData()->getEntradaDetalle();
            
 // Se modifica la Existencia de la Entrada Detalles                   
                $cantidadActual = $articuloSalida->getCantidad();
                $precioActual = $articuloSalida->getPrecio();
                $aplicaIvaActual = $articuloSalida->getAplicaIva();
                
                $existencia = $existenciasManager->buscar($salidasDetalle->getArticulo(), $salidasDetalle->getSalida()->getPrograma(), false);
                
                $sdsManager->actualizarExistenciaSDS(
                    $salidasDetalle, $cantidadActual, $precioActual, 
                    $ejercicio, $existencia, $aplicaIvaActual
                );
// Termina modifica la Existencia de la Entrada Detalles                
// Se modifica la Existencia del Articulo    
                $articuloObj = $articulosRepository->findOneBy(array('id' => $articuloSalida->getArticulo()->getId()));
                
                $existenciasManager->disminuir($articuloObj, 
                $salidasDetalle->getSalida()->getPrograma(),
                $salidasDetalle->getCantidad(), 
                $salidasDetalle->getEntradaDetalle()->getPrecio(),
                $ejercicio,
                $salidasDetalle->getEntradaDetalle()->getAplicaIva()
                );
// Termina modifica la Existencia del Articulo               
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            throw $e;
        }
        
        $entradaDetallesManager = $this->get('app.entrada_detalles');
        $precioNuevo = $entradaDetallesManager->calcularPrecio($salidasDetalle->getEntradaDetalle()->getPrecio(), $ejercicio['iva'], $salidasDetalle->getEntradaDetalle()->getAplicaIva());
        $total = round($precioNuevo * $salidasDetalle->getCantidad(), 2);
        $btnEditar =  '<button type="button" detalle-id="'.$salidasDetalle->getId().'" 
            class="btn btn-xs btn-primary btn-editar-articulo" data-toggle="tooltip" 
            title="Editar"> <i class="fa fa-edit fa-fw"></i></button>';  
        $registro = array(
            'clave' => $salidasDetalle->getArticulo()->getClave(),
            'nombre' => Helpers::getSubString($salidasDetalle->getArticulo()->getNombre()),
            'cantidad' => number_format($salidasDetalle->getCantidad(), 0, '.', ','),
            'precio' => number_format($precioNuevo, 2, '.', ','),
            'total' => number_format($total, 2, '.', ','),
            'btn_editar' => $btnEditar,
        );
        $data = array('code' => 200, 'html' => '', 
            'message' => 'El artículo se agrego a la Salida correctamente.',
            'registro' => $registro,
        );
        
         $response = new JsonResponse($data);
         return $response;
    }
    
    public function newAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $entity = new SalidaDetalles();
            $salidaId = $request->query->get('salidaId');
            
            
            $em = $this->getDoctrine()->getManager();
            $salida = $em->getRepository("AppBundle:Salidas")->find($salidaId);
            $entity->setSalida($salida);
            
            $form = $this->createCreateForm($entity);

            $html = $this->renderView('/Admin/SalidaDetalles/new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView(),
                'salida' => $salida
            ));
            
            $data = array('code' => 200, 'html' => $html, 'message' => 'Correcto');
            $response = new JsonResponse($data);
            return $response;
        }
    }
    
     private function createCreateForm(SalidaDetalles $entity)
    {
        $form = $this->createForm(new SalidaDetallesType(), $entity, array(
            'action' => $this->generateUrl('admin_salidadetalles_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Guardar',
            'attr' => array('class' => 'btn-primary'),
            'icon' => 'floppy-disk'
        ));

        return $form;
    }
    
   
    
    public function popupBuscarEntradaDetallesAction(Request $request)
    {
        $acciones = $request->query->get('acciones');
        $salidaId = $request->query->get('salidaId');
        $articuloClave = $request->query->get('articulo');
        $em = $this->getDoctrine()->getManager();
        
        $salida = $em->getRepository('AppBundle:Salidas')->find($salidaId);
        
        $entradas = $em->getRepository("AppBundle:EntradaDetalles")->recuperarListaEntradaDetalles($salida->getPrograma()->getId(), $articuloClave);
        
        $html = $this->renderView('/Admin/SalidaDetalles/popup_buscar_entradaDetalles.html.twig', array(
            'acciones' => $acciones,
            'entradas' => $entradas,
            'salida'   => $salidaId,
        ));
        
        
        $data = array('code' => 200, 'html' => $html, 'message' => 'El proceso se realizó correctamente');
        $response = new JsonResponse($data);
        return $response;
    }
}
