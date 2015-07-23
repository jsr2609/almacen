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
        $this->pdf->SetMargins(6.5, PDF_MARGIN_TOP, 6.5);
        $this->pdf->SetFont('helvetica', 'B', 13);
        $this->pdf->Cell(0, 0, 'KARDEX', '', 1, 'C');
        
        $this->pdf->SetFont('helvetica', '', 10);
        $this->pdf->Ln(5);
        $articuloNombre = Helpers::getSubString($this->articulo['nombre'], 50);
        $this->pdf->Cell(0,0, 'Articulo: '.$this->articulo['clave'].' '.$articuloNombre, 0, 1);
        $this->pdf->Cell(0,0, 'Presentación: ...', 0, 1);
        
        $programaNombre = ($this->datos['programa'] == null) ? "Todos" : $this->datos['programa']->getNombre();
        $this->pdf->Cell(0,0, 'Programa: '.$programaNombre, 0, 1);
        $this->pdf->Ln(3);
        
        $this->pdf->Cell(10,0, 'Del:', 0, 0);
        $this->pdf->Cell(35,0, $this->fechaInicial->format('d/m/Y'), 0, 0);
        
        $this->pdf->Cell(10,0, 'Al:', 0, 0);
        $this->pdf->Cell(20,0, $this->fechaFinal->format('d/m/Y'), 0, 1);
        
        $this->pdf->Ln(3);
        
        $wCampos = array(
            'wFecha' => 16,
            'wFolio' => 15, 
            'wCantidad' => 15, 
            'wPrecio' => 23, 
            'wTotal' => 23,
        );
        $wPage = $this->pdf->getPageWidth();
        $paginaInicial = $this->pdf->getPage();
        $yInicial = $this->pdf->GetY();
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
        $this->pdf->Cell(30, 0, "Cantidad", "LTRB", 0, "C");
        $this->pdf->Cell(30, 0, "Dinero", "LTRB", 1, "C");
        
        $this->pdf->Cell(30, 0, "Entradas", "LTRB", 0, "R");
        $this->pdf->Cell(30, 0, number_format($rEntradas['total_cantidad'], 0, '.', ','), "LTRB", 0, "R");
        $this->pdf->Cell(30, 0, number_format($rEntradas['total_dinero'], 2, '.', ','), "LTRB", 1, "R");
        
        $this->pdf->Cell(30, 0, "Salidas", "LTRB", 0, "R");
        $this->pdf->Cell(30, 0, number_format($rSalidas['total_cantidad'], 0, '.', ','), "LTRB", 0, "R");
        $this->pdf->Cell(30, 0, number_format($rSalidas['total_dinero'], 2, '.', ','), "LTRB", 1, "R");
        
        $this->pdf->Cell(30, 0, "Existencias", "LTRB", 0, "R");
        $existenciaCantidad = $rEntradas['total_cantidad'] - $rSalidas['total_cantidad'];
        $existenciaDinero = $rEntradas['total_dinero'] - $rSalidas['total_dinero'];
        $this->pdf->Cell(30, 0, number_format($existenciaCantidad, 0, '.', ','), "LTRB", 0, "R");
        $this->pdf->Cell(30, 0, number_format($existenciaDinero, 2, '.', ','), "LTRB", 1, "R");
        
    }
    
    public function imprimirEntradas($wCampos, $wPage)
    {
        $wPage = $this->pdf->getFullPageWidth();
        $this->pdf->Cell($wPage / 2 - 3,0, 'ENTRADAS', '', 1, 'C');
        $this->pdf->Ln(1);
        $this->pdf->Cell($wCampos['wFecha'], 0, 'Fecha', 'LTRB', 0, 'C');
        $this->pdf->Cell($wCampos['wFolio'],0, 'Folio', 'LTRB', 0, 'C');
        $this->pdf->Cell($wCampos['wCantidad'],0, 'Cantidad', 'LTRB', 0, 'C');
        $this->pdf->Cell($wCampos['wPrecio'],0, 'Precio', 'LTRB', 0, 'C');
        $this->pdf->Cell($wCampos['wTotal'],0, 'Total', 'LTRB', 1, 'C');
        $this->pdf->SetFont('helvetica', '', 8);
        $totalDinero = 0;
        $totalCantidad = 0;
        
        foreach($this->entradas as $entrada)
        {
            $this->pdf->Cell($wCampos['wFecha'],0, $entrada['fecha']->format('d/m/Y'), 'LTRB', 0, 'C');
            $this->pdf->Cell($wCampos['wFolio'],0, $entrada['folio'], 'LTRB', 0, 'R');
            $this->pdf->Cell($wCampos['wCantidad'],0, number_format($entrada['cantidad'], 0, '.', ','), 'LTRB', 0, 'R');
            $precio = number_format($entrada['precio'], 2, '.', ',');
            $this->pdf->Cell($wCampos['wPrecio'],0, $precio, 'LTRB', 0, 'R');
            $total = round($entrada['precio'] * $entrada['cantidad'], 2);
            $this->pdf->Cell($wCampos['wTotal'],0, number_format($total, 2, '.', ','), 'LTRB', 1, 'R');
            
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
        $this->pdf->SetFont('helvetica', '', 10);
        $this->pdf->Cell(0,0, 'SALIDAS', '', 1, 'C');
        $this->pdf->Ln(1);
        $this->pdf->SetX($x);
        $this->pdf->Cell($wCampos['wFolio'], 0, 'Oficina', 'LTRB', 0, 'C');
        $this->pdf->Cell($wCampos['wFecha'], 0, 'Fecha', 'LTRB', 0, 'C');
        $this->pdf->Cell($wCampos['wFolio'],0, 'Folio', 'LTRB', 0, 'C');
        $this->pdf->Cell($wCampos['wCantidad'],0, 'Cantidad', 'LTRB', 0, 'C');
        $this->pdf->Cell($wCampos['wPrecio'],0, 'Precio', 'LTRB', 0, 'C');
        $this->pdf->Cell($wCampos['wTotal'],0, 'Total', 'LTRB', 1, 'C');
        $this->pdf->SetFont('helvetica', '', 8);
        $totalDinero = 0;
        $totalCantidad = 0;
        
        foreach($this->salidas as $salida) {            
            $this->pdf->SetX($x);
            $this->pdf->Cell($wCampos['wFolio'],0, $salida['destinoClave'], 'LTRB', 0, 'C');
            $this->pdf->Cell($wCampos['wFecha'],0, $salida['fecha']->format('d/m/Y'), 'LTRB', 0, 'C');
            $this->pdf->Cell($wCampos['wFolio'],0, $salida['folio'], 'LTRB', 0, 'R');
            $this->pdf->Cell($wCampos['wCantidad'],0, number_format($salida['cantidad'], 0, '.', ','), 'LTRB', 0, 'R');
            $precio = number_format($salida['precio'], 2, '.', ',');
            $this->pdf->Cell($wCampos['wPrecio'],0, $precio, 'LTRB', 0, 'R');
            $total = round($salida['precio'] * $salida['cantidad'], 2);
            $this->pdf->Cell($wCampos['wTotal'],0, number_format($total, 2, '.', ','), 'LTRB', 1, 'R');
            
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