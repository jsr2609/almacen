<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\SalidaDetalles;
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
            'entrada' => $entrada,
        ));
       
    }
}
