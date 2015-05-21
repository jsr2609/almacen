<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\Destinos;

/**
 * Destinos controller.
 *
 */
class DestinosController extends Controller
{

    public function popupBuscarAction(Request $request)
    {
        $acciones = $request->query->get('acciones');
        
        $em = $this->getDoctrine()->getManager();
        $destinos = $em->getRepository("AppBundle:Destinos")->recuperarListaDestinos();
        $html = $this->renderView('/Admin/Destinos/popup_buscar.html.twig', array(
            'acciones' => $acciones,
            'destinos' => $destinos,
        ));
        
        $data = array('code' => 200, 'html' => $html, 'message' => 'El proceso se realizó correctamente');
        $response = new JsonResponse($data);
        return $response;
    }
}
