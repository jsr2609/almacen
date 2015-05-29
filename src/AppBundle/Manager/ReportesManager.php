<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaseManager
 *
 * @author jsr
 */

namespace AppBundle\Manager;

use SSA\UtilidadesBundle\Manager\BaseManager;
use AppBundle\PDF\BasePDF;


class ReportesManager 
{
    
    public function __construct(BaseManager $base)
    {
        $this->base = $base;
    }
    
    public function kardex(\TCPDF $pdf)
    {
        $bPDF = new BasePDF();
        $footerText = array(
            'address' => $entrada['ejercicio']['almacen']['domicilio'],
            'telephones' => $entrada['ejercicio']['almacen']['telefonos'],
        );
        $bPDF->init($pdf, $entrada['ejercicio']['almacen']['nombre'], $footerText);
        
        return $pdf;
    }
    
}