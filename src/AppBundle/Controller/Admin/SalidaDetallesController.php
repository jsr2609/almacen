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
        $html = $this->renderView('/Admin/Entradas/popup_buscar.html.twig', array(
        
            'entradas' => $entradas,
        ));
        
        $data = array('code' => 200, 'html' => $html, 'message' => 'El proceso se realizó correctamente');
        $response = new JsonResponse($data);
        return $response;
    }

    
}
