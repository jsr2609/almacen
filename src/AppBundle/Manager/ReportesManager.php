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
    private $base;
    
    public function __construct(BaseManager $base)
    {
        $this->base = $base;
    }
    
    public function kardex(\TCPDF $pdf, $ejercicio, $datos, $articulo)
    {
        $bPDF = new BasePDF();
        $footerText = array(
            'address' => $ejercicio['almacen']['domicilio'],
            'telephones' => $ejercicio['almacen']['telefonos'],
        );        
        $edsRepository = $this->base->getRepository("AppBundle:EntradaDetalles");
        $sdsRepository = $this->base->getRepository("AppBundle:SalidaDetalles");
        $sEntradas = 'ets.fecha, ets.folio, eds.cantidad, eds.precio';
        $entradas = $edsRepository->buscarParaKardex($articulo['id'], $sEntradas);
        
        $bPDF->init($pdf, $ejercicio['almacen']['nombre'], $footerText);
        $kardex = new Kardex($pdf, $datos, $articulo, $entradas);
        
        $kardex->generar();
        return $pdf;
    }
    
}