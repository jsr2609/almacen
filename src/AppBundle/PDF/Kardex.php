<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\PDF;

use SSA\UtilidadesBundle\Helper\Helpers;

class Kardex
{
    private $pdf;
    
    public function __construct(\TCPDF $pdf)
    {
        $this->pdf = $pdf;
    }
    
    public function generar($datos, $articulo)
    {
        
        $this->pdf->SetFont('helvetica', 'B', 13);
        $this->pdf->Cell(0, 0, 'KARDEX', '', 1, 'C');
        
        $this->pdf->SetFont('helvetica', '', 10);
        $this->pdf->Ln(5);
        $articuloNombre = Helpers::getSubString($articulo['nombre'], 50);
        $this->pdf->Cell(0,0, 'Articulo: '.$articulo['clave'].' '.$articuloNombre, 0, 1);
        $this->pdf->Cell(0,0, 'Presentación: ...', 0, 1);
        
        $programaNombre = ($datos['programa'] == null) ? "" : $datos['programa']->getNombre();
        $this->pdf->Cell(0,0, 'Programa: '.$programaNombre, 0, 1);
        
        return $this->pdf;
    }
}