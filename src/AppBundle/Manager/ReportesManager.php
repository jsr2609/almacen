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
use AppBundle\PDF\Kardex;


class ReportesManager 
{
    
    public function __construct(BaseManager $base)
    {
        $this->base = $base;
    }
    
    public function kardex(\TCPDF $pdf, $ejercicio)
    {
        $bPDF = new BasePDF();
        $footerText = array(
            'address' => $ejercicio['almacen']['domicilio'],
            'telephones' => $ejercicio['almacen']['telefonos'],
        );
        $bPDF->init($pdf, $ejercicio['almacen']['nombre'], $footerText);
        $kardex = new Kardex($pdf);
        $kardex->generar();
        return $pdf;
    }
    
}