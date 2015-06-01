<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\PDF;


class Kardex
{
    private $pdf;
    
    public function __construct(\TCPDF $pdf)
    {
        $this->pdf = $pdf;
    }
    
    public function generar()
    {
        $this->pdf->SetFont('helvetica', 'B', 13);
        $this->pdf->Cell(0, 0, 'KARDEX', '', 1, 'C');
        
        $this->pdf->SetFont('helvetica', '', 10);
        $this->pdf->Ln(5);
        
        $this->pdf->Cell(0,0, 'Articulo: ');
        return $this->pdf;
    }
}