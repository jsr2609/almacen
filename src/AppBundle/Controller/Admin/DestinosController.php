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
    
    public function buscarAjaxAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $campo = $request->query->get('campo');            
            $valor = $request->query->get('valor');
            $campo = ($campo === NULL) ? 'clave' : $campo;
            $repository = $this->getDoctrine()->getManager()->getRepository("AppBundle:Destinos");
            $destino = $repository->findOneBy(array(
                'clave' => $valor
            ));
            
            if(!$destino) {
                $code = 500;
                $message = "El destino $valor no existe";
                $datosDestino = null;
            } else {
                $code = 200;
                $datosDestino = array(
                    'id' => $destino->getId(), 
                    'clave' => $destino->getClave(),
                    'nombre' => $destino->getNombre(),
                );
                $message = null;
            }
            
            $data = array(
                'code' => $code,
                'destino' => $datosDestino,
                'message' => $message,
            );
            
            $response = new JsonResponse($data);
            
            return $response;        
        }
    }
}
