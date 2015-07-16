<?php

namespace AppBundle\Controller\Admin;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\SalidaDetalles;
use AppBundle\Entity\Entradas;
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
        
        $ejerciciosManager = $this->get('app.ejercicios');
        $iva = $ejerciciosManager->obtenerIVAPorAlmacenYPeriodo();
        
        $detallesManager = $this->get('app.salida_detalles');
        $entities = $detallesManager->listaArticulosPorSalida($salida->getId(), $iva);
              
        return $this->render('/Admin/SalidaDetalles/indexDirecta.html.twig', array(
            'entities' => $entities,
            'salida' => $salida,
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
                
                $articuloObj = $articulosRepository->findOneBy(array('clave' => $articuloSalida->getArticulo()->getClave()));
                
                $em->persist($salidasDetalle);

                $existenciasManager->disminuir($articuloObj, 
                    $salidasDetalle->getSalida()->getPrograma(),
                    $salidasDetalle->getCantidad(), 
                    $salidasDetalle->getEntradaDetalle()->getPrecio(),
                    $ejercicio,
                    $salidasDetalle->getEntradaDetalle()->getAplicaIva()
                );



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
    
    private function addFlash($type, $message) {
        $this->getRequest()->getSession()->getFlashBag()->add(
            $type,
            $message
        );
    }
}
