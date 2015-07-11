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
            $datos = $form->getData();
            
            $tcpdfManager = $this->get('white_october.tcpdf');
            
            $pdf = $tcpdfManager->create(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT);
            
            
            $reportesManager = $this->get('app.reportes');
            $ejerciciosManager = $this->get('app.ejercicios');
            $ejercicio = $ejerciciosManager->buscarPorAlmacenYPeriodo(null, null, 'HYDRATE_ARRAY');
            
            $articulosManager = $this->get('app.articulos');
            $articulo = $articulosManager->buscar($datos['articulo'], null, null, 'HYDRATE_ARRAY');
            
            $reportesManager->kardex($pdf, $ejercicio, $datos, $articulo);
            $pdf->output('kardex.pdf', 'D');   
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