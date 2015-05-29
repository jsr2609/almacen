<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Form\KardexType;

/**
 * Programas controller.
 *
 */
class ReportesController extends Controller
{
    public function kardexFormAction()
    {
        $form = $this->crearKardexForm();
        
        return $this->render("/Admin/Reportes/kardex_form.html.twig", array(
            'form' => $form->createView(),
        ));
    }
    
    public function kardexPdfAction(Request $request)
    {
        $form = $this->crearKardexForm();
        $form->handleRequest($request);
        if($form->isValid()) {
            $tcpdfManager = $this->get('white_october.tcpdf');
            
            $pdf = $tcpdfManager->create();
            $reportesManager = $this->get('app.reportes');
            $ejerciciosManager = $this->get('app.ejercicios');
            $ejercicio = $ejerciciosManager->buscarPorAlmacenYPeriodo(null, null, 'HYDRATE_ARRAY');
            
            $reportesManager->kardex($pdf);
            $pdf->output('entrada.pdf', 'D');   
        } 
        
        return $this->render("/Admin/Reportes/kardex_form.html.twig", array(
            'form' => $form->createView(),
        ));
    }
    
    private function crearKardexForm()
    {
        $form = $this->createForm(new KardexType(), null, array(
            'action' => $this->generateUrl('admin_reportes_kardex_pdf'),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array(
            'label' => 'Generar',
            'attr' => array('class' => 'btn-primary'),
            'icon' => 'file',
        ));
        
        return $form;
    }
     
}