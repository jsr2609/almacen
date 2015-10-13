<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\PDF;

use SSA\UtilidadesBundle\Helper\Helpers;
use SSA\UtilidadesBundle\Helper\DateToText;

class Kardex
{
    private $pdf;
    private $datos;
    private $articulo;
    private $fechaInicial;
    private $fechaFinal;
    private $entradas;
    private $salidas;
    
    public function __construct(\TCPDF $pdf, $datos, $articulo, $entradas, $salidas)
    {
        $this->pdf = $pdf;
        $this->datos = $datos;
        $this->articulo = $articulo;
        $this->fechaInicial = $this->generarFechaInicial($datos['fechaInicial']);
        $this->fechaFinal = $this->generarFechaFinal($datos['fechaFinal']);
        $this->entradas = $entradas;
        $this->salidas = $salidas;
        
        
    }
    
    public function generar()
    {
        $this->pdf->SetMargins(5, PDF_MARGIN_TOP, 5);
        $this->pdf->SetFont('helvetica', 'B', 10);
        $this->pdf->Cell(0, 0, 'KARDEX', '', 1, 'C');
        
        $this->pdf->SetFont('helvetica', '', 8);
        $this->pdf->Ln(5);
        $this->pdf->SetFillColor(230, 230, 230);
        //$this->pdf->Cell($w, $h, $txt, $border, $ln, $align, $fill, $link, $stretch, $ignore_min_height, $calign, $valign)
        $this->pdf->Cell(0,5, 'ARTICULO', "LTRB", 1, 'C', true);
        $articuloNombre = Helpers::getSubString($this->articulo['nombre'], 300);
        //$this->pdf->MultiCell($w, $h, $txt, $border, $align, $fill, $ln, $x, $y, $reseth, $stretch, $ishtml, $autopadding, $maxh, $valign, $fitcell)
        
        $this->pdf->MultiCell(0,5,$this->articulo['clave'].' '.$articuloNombre, 'LTRB', 'L',0,1);
        $this->pdf->Cell(30,5, 'PRESENTACION', 'LTRB', 0, 'L', true);
        $this->pdf->Cell(0,5, $this->articulo['presentacionNombre'],  'LTRB', 1, 'L', false);
        $this->pdf->Cell(30,5, 'PROGRAMA', 'LTRB', 0, 'L', true);
        $programaNombre = ($this->datos['programa'] == null) ? "Todos" : $this->datos['programa']->getNombre();
        $this->pdf->Cell(0,5, $programaNombre, 'LTRB', 1);
        $this->pdf->Ln(3);
        $dateToText = new DateToText();
        
        $this->pdf->Cell(35,0, "Del ".$dateToText->getText($this->fechaInicial)." al ".$dateToText->getText($this->fechaFinal), 0, 1);
        
        $this->pdf->Ln(3);
        ;
        $wCampos = array(
            'wFecha' => 14,
            'wPrograma' => 24,
            'wDestino' => 17,
            'wFolio' => 10, 
            'wCantidad' => 12, 
            'wPrecio' => 15, 
            'wTotal' => 16,
        );
        $wPage = $this->pdf->getPageWidth();
        $paginaInicial = $this->pdf->getPage();
        $yInicial = $this->pdf->GetY();
        $this->pdf->setCellPaddings(0.3, 1, 0.3);
        
        $rEntradas = $this->imprimirEntradas($wCampos, $wPage);
        $rSalidas = $this->imprimirSalidas($wCampos, $wPage, $paginaInicial, $yInicial);
        
        $this->imprimirBalance($rEntradas, $rSalidas);
        return $this->pdf;
    }
    
    public function imprimirBalance($rEntradas, $rSalidas)
    {
        $y = ($rEntradas['y_final'] > $rSalidas['y_final']) ? $rEntradas['y_final'] : $rSalidas['y_final'];
        
        $this->pdf->SetY($y);
        $this->pdf->Ln(5);
        $this->pdf->SetFont('helvetica', 'B', 10);
        $this->pdf->Cell(30, 0, "BALANCE", "", 1, "L");
        $this->pdf->SetFont('helvetica', '', 8);
        $this->pdf->Ln(5);
        $this->pdf->Cell(30, 0, "", "", 0, "C");
        $this->pdf->Cell(30, 0, "Cantidad", "LTRB", 0, "C", 1);
        $this->pdf->Cell(30, 0, "Dinero", "LTRB", 1, "C", 1);
        
        $this->pdf->Cell(30, 0, "Entradas", "LTRB", 0, "R", 1);
        $this->pdf->Cell(30, 0, number_format($rEntradas['total_cantidad'], 0, '.', ','), "LTRB", 0, "R");
        $this->pdf->Cell(30, 0, number_format($rEntradas['total_dinero'], 2, '.', ','), "LTRB", 1, "R");
        
        $this->pdf->Cell(30, 0, "Salidas", "LTRB", 0, "R", 1);
        $this->pdf->Cell(30, 0, number_format($rSalidas['total_cantidad'], 0, '.', ','), "LTRB", 0, "R");
        $this->pdf->Cell(30, 0, number_format($rSalidas['total_dinero'], 2, '.', ','), "LTRB", 1, "R");
        
        $this->pdf->Cell(30, 0, "Existencias", "LTRB", 0, "R", 1);
        $existenciaCantidad = $rEntradas['total_cantidad'] - $rSalidas['total_cantidad'];
        $existenciaDinero = $rEntradas['total_dinero'] - $rSalidas['total_dinero'];
        $this->pdf->Cell(30, 0, number_format($existenciaCantidad, 0, '.', ','), "LTRB", 0, "R");
        $this->pdf->Cell(30, 0, number_format($existenciaDinero, 2, '.', ','), "LTRB", 1, "R");
        
    }
    
    public function imprimirEntradas($wCampos, $wPage)
    {
        $this->pdf->SetFont('helvetica', '', 8);
        $wPage = $this->pdf->getFullPageWidth();
        $this->pdf->Cell($wPage / 2 - 3,0, 'ENTRADAS', '', 1, 'C');
        $this->pdf->Ln(1);
        $this->pdf->Cell($wCampos['wFecha'], 5, 'Fecha', 'LTRB', 0, 'C', 1);
        $this->pdf->Cell($wCampos['wPrograma'],5, 'Programa', 'LTRB', 0, 'C', 1);
        $this->pdf->Cell($wCampos['wFolio'],5, 'Folio', 'LTRB', 0, 'C', 1);
        $this->pdf->Cell($wCampos['wCantidad'],5, 'Cantidad', 'LTRB', 0, 'C', 1);
        $this->pdf->Cell($wCampos['wPrecio'],5, 'Precio', 'LTRB', 0, 'C', 1);
        $this->pdf->Cell($wCampos['wTotal'],5, 'Total', 'LTRB', 1, 'C', 1);
        $this->pdf->SetFont('helvetica', '', 7);
        $totalDinero = 0;
        $totalCantidad = 0;
        
        foreach($this->entradas as $entrada)
        {
            $this->pdf->Cell($wCampos['wFecha'],5, $entrada['fecha']->format('d/m/Y'), 'LTRB', 0, 'C');
            $this->pdf->Cell($wCampos['wPrograma'],5, 'GASTOPER_SEGU', 'LTRB', 0, 'L');
            $this->pdf->Cell($wCampos['wFolio'],5, $entrada['folio'], 'LTRB', 0, 'R');
            $this->pdf->Cell($wCampos['wCantidad'],5, number_format($entrada['cantidad'], 0, '.', ','), 'LTRB', 0, 'R');
            $precio = number_format($entrada['precio'], 2, '.', ',');
            $this->pdf->Cell($wCampos['wPrecio'],5, $precio, 'LTRB', 0, 'R');
            $total = round($entrada['precio'] * $entrada['cantidad'], 2);
            $this->pdf->Cell($wCampos['wTotal'],5, number_format($total, 2, '.', ','), 'LTRB', 1, 'R');
            
            $totalCantidad = $totalCantidad + $entrada['cantidad'];
            $totalDinero = $totalDinero + $total;
            
        }
        
        return array(
            'y_final' => $this->pdf->GetY(),
            'total_dinero' => $totalDinero,
            'total_cantidad' => $totalCantidad,
        );
        
    }
    
    public function imprimirSalidas($wCampos, $wPage, $paginaInicial, $yInicial)
    {
        
        $this->pdf->setPage($paginaInicial);
        $this->pdf->SetY($yInicial);
        $x = $wPage / 2 - 6;
        $this->pdf->SetX($x);
        $this->pdf->SetFont('helvetica', '', 8);
        $this->pdf->Cell(0,0, 'SALIDAS', '', 1, 'C');
        $this->pdf->Ln(1);
        $this->pdf->SetX($x);
        
        $this->pdf->Cell($wCampos['wFecha'], 5, 'Fecha', 'LTRB', 0, 'C', 1);
        
        $this->pdf->Cell($wCampos['wPrograma'],5, 'Programa', 'LTRB', 0, 'C', 1);
        $this->pdf->Cell($wCampos['wDestino'], 5, 'Destino', 'LTRB', 0, 'C', 1);
        $this->pdf->Cell($wCampos['wFolio'],5, 'Folio', 'LTRB', 0, 'C', 1);
        $this->pdf->Cell($wCampos['wCantidad'],5, 'Cantidad', 'LTRB', 0, 'C', 1);
        $this->pdf->Cell($wCampos['wPrecio'],5, 'Precio', 'LTRB', 0, 'C', 1);
        $this->pdf->Cell(0,5, 'Total', 'LTRB', 1, 'C', 1);
        $this->pdf->SetFont('helvetica', '', 7);
        $totalDinero = 0;
        $totalCantidad = 0;
        
        foreach($this->salidas as $salida) {            
            $this->pdf->SetX($x);
            $this->pdf->Cell($wCampos['wFecha'],5, $salida['fecha']->format('d/m/Y'), 'LTRB', 0, 'C');
            $this->pdf->Cell($wCampos['wPrograma'],5, 'GASTOPER_SEGU', 'LTRB', 0, 'L');
            $this->pdf->Cell($wCampos['wDestino'],5, $salida['destinoClave'], 'LTRB', 0, 'L');
            $this->pdf->Cell($wCampos['wFolio'],5, $salida['folio'], 'LTRB', 0, 'R');
            $this->pdf->Cell($wCampos['wCantidad'],5, number_format($salida['cantidad'], 0, '.', ','), 'LTRB', 0, 'R');
            $precio = number_format($salida['precio'], 2, '.', ',');
            $this->pdf->Cell($wCampos['wPrecio'],5, $precio, 'LTRB', 0, 'R');
            $total = round($salida['precio'] * $salida['cantidad'], 2);
            $this->pdf->Cell(0,5, number_format($total, 2, '.', ','), 'LTRB', 1, 'R');
            
            $totalDinero = $totalDinero + $total;
            $totalCantidad = $totalCantidad + $salida['cantidad'];
        }
        
        return array(
            'y_final' => $this->pdf->GetY(),
            'total_dinero' => $totalDinero,
            'total_cantidad' => $totalCantidad,
        );
        
    }
    
    private function generarFechaInicial(\DateTime $fecha = NULL)
    {
        if(!$fecha)
        {            
            $anioActual = date('Y');
            $fecha = new \DateTime($anioActual.'-01-01');            
        }
        
        return $fecha;
    }
    
    private function generarFechaFinal(\DateTime $fecha = NULL)
    {
        if(!$fecha)
        {            
            $fecha = new \DateTime();   
        }
        
        return $fecha;
    }
    
    public function getFechaInicial()
    {
        return $this->fechaInicial;
    }
    
    public function getFechaFinal()
    {
        return $this->fechaFinal;
    }
}