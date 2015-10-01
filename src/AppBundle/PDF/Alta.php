<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\PDF;

use AppBundle\Repository\EntradaDetallesRepository;
use AppBundle\PDF\MyTCPDF;
use AppBundle\PDF\AltasTCPDF;
use SSA\UtilidadesBundle\Helper\Helpers;

/**
 * Description of Alta
 *
 * @author jsr
 */
class Alta 
{
    private $pdf;
    private $entrada;
    private $wCs;
    
    public function __construct(AltasTCPDF $pdf, $entrada) 
    {
        $this->pdf = $pdf;
        $this->entrada = $entrada;
    }
     
    
    
    public function imprimirDetalles(EntradaDetallesrepository $edsRepository)
    {
        $this->pdf->SetFont('helvetica', '', 8);
        
        $wPage = $this->pdf->getPageWidth() - PDF_MARGIN_LEFT - PDF_MARGIN_RIGHT;
        $wCve = 20;
        $wNombre = 80;
        $wCaducidad = 15;
        $wCantidad = 15;
        $wUnidad = 20;
        $wPrecio = 20;
        $wImporte = 20;
        $hCell = 5;
        
        $this->pdf->SetFillColor(230, 230, 230);
        
        
        $this->pdf->cell($wCve, $hCell, 'CLAVE', 'LTRB', 0, 'C', 1);
        $this->pdf->cell($wNombre, $hCell, 'NOMBRE', 'LTRB', 0, 'C', 1);
        $this->pdf->cell($wCaducidad, $hCell, 'CAD.', 'LTRB', 0, 'C', 1);
        $this->pdf->cell($wCantidad, $hCell, 'CANTIDAD', 'LTRB', 0, 'C', 1);
        $this->pdf->cell($wUnidad, $hCell, 'UNIDAD', 'LTRB', 0, 'C', 1);
        $this->pdf->cell($wPrecio, $hCell, 'PRECIO', 'LTRB', 0, 'C', 1);
        $this->pdf->cell($wImporte, $hCell, 'IMPORTE', 'LTRB', 1, 'C', 1);
        
        
        
        $this->pdf->SetFont('helvetica', '', 8);
        
        $partidas = $edsRepository->obtenerPartidasPorEntrada($this->entrada['id']);
        $selectEds = 'ats.clave, ats.nombre, eds.fechaCaducidad, eds.cantidad, '
            . 'pss.nombre AS presentacionNombre, eds.precio, eds.aplicaIva';
        
        $total = 0;
        $iva = $this->entrada['ejercicio']['iva'];
        
        foreach($partidas as $partida) {
            $this->pdf->SetFont('helvetica', 'B', 8);
            $this->pdf->cell($wImporte, $hCell, $partida['clave']." ".$partida['nombre'], '', 1, 'l');
            $this->pdf->Ln(1);
            $this->pdf->SetFont('helvetica', '', 8);
            
            $detalles = $edsRepository->buscarTodos($selectEds, $this->entrada['id'], $partida['id']);
            $subtotalPartida = 0;
            foreach($detalles as $detalle){
                //Articulos
                $this->pdf->cell($wCve, $hCell, $detalle['clave'], 'LTRB', 0, 'C');
                $this->pdf->cell($wNombre, $hCell, Helpers::getSubString($detalle['nombre'], 45), 'LTRB', 0, 'L');
                $this->pdf->cell($wCaducidad, $hCell, $detalle['fechaCaducidad'], 'LTRB', 0, 'C');
                $this->pdf->cell($wCantidad, $hCell, number_format($detalle['cantidad'], 0, '.', ','), 'LTRB', 0, 'R');
                $this->pdf->cell($wUnidad, $hCell, $detalle['presentacionNombre'], 'LTRB', 0, 'C');
                $precio = $detalle['precio'];
                if($detalle['aplicaIva']) {
                    $precio = round($precio + ($precio * $iva / 100), 2);
                }
                $this->pdf->cell($wPrecio, $hCell, number_format($precio, 2, '.', ','), 'LTRB', 0, 'R');
                $importe = round($precio * $detalle['cantidad'], 2);
                
                $this->pdf->cell($wImporte, $hCell, number_format($importe, 2, '.', ','), 'LTRB', 1, 'R');
                $subtotalPartida += $importe;
            }
            $subtotalPartida = round($subtotalPartida, 2);
            $this->pdf->cell($wCve, $hCell, '', '', 0, 'C');
            $this->pdf->cell($wNombre, $hCell, '', '', 0, 'L');
            $this->pdf->cell($wCaducidad, $hCell, '', '', 0, 'C');
            $this->pdf->cell($wCantidad, $hCell, '', '', 0, 'R');
            $this->pdf->cell($wUnidad, $hCell, '', '', 0, 'C');
            $this->pdf->cell($wPrecio, $hCell, 'SUBTOTAL', '', 0, 'R');
            
            $this->pdf->cell($wImporte, $hCell, number_format($subtotalPartida, 2, '.', ','), '', 1, 'R');
            
            
            
            
            
            $total += $subtotalPartida;
        }
        
        $this->pdf->Ln(5);
        $total = round($total, 2);
        $this->pdf->cell($wCve, $hCell, '', '', 0, 'C');
        $this->pdf->cell($wNombre, $hCell, '', '', 0, 'L');
        $this->pdf->cell($wCaducidad, $hCell, '', '', 0, 'C');
        $this->pdf->cell($wCantidad, $hCell, '', '', 0, 'R');
        $this->pdf->cell($wUnidad, $hCell, '', '', 0, 'C');
        $this->pdf->cell($wPrecio, $hCell, 'TOTAL', '', 0, 'R');

        $this->pdf->cell($wImporte, $hCell, number_format($total, 2, '.', ','), '', 1, 'R');
        /**
        for($i= 0; $i < 100; $i++) {
            $this->pdf->cell($wCve, $hCell, 'CLAVE', 'LTRB', 0, 'C', 1);
        $this->pdf->cell($wNombre, $hCell, 'NOMBRE', 'LTRB', 0, 'C', 1);
        $this->pdf->cell($wCaducidad, $hCell, 'CAD.', 'LTRB', 0, 'C', 1);
        $this->pdf->cell($wCantidad, $hCell, 'CANTIDAD', 'LTRB', 0, 'C', 1);
        $this->pdf->cell($wUnidad, $hCell, 'UNIDAD', 'LTRB', 0, 'C', 1);
        $this->pdf->cell($wPrecio, $hCell, 'PRECIO', 'LTRB', 0, 'C', 1);
        $this->pdf->cell($wImporte, $hCell, 'IMPORTE', 'LTRB', 1, 'C', 1);
        }*/
        
        
    }
    
    public function imprimirFirmas()
    {
        $margins = $this->pdf->getMargins();
        $pageW = $this->pdf->getPageWidth() - $margins['left'] - $margins['right'];
        $wCell = $pageW / 3;
        $yActual = $this->pdf->GetY();
        $hC = $this->pdf->getCellHeight($this->pdf->getFontSize());
        $iFirmas = $this->pdf->getPageHeight() - $this->pdf->getBreakMargin() - $hC * 3 -5;
        if($yActual < $iFirmas) {
            $this->pdf->SetY($iFirmas);
            
        } else {
            $this->pdf->AddPage();
            $this->pdf->SetY($iFirmas);
        }
        $this->pdf->cell(0, 0, '', '', 1, 'C');
        $yI = $this->pdf->GetY();
        $this->pdf->cell($wCell, 0, $this->entrada['ejercicio']['almacen']['nombreRecursosMateriales'], 'B', 0, 'C');
        $this->pdf->cell($wCell, 0, "", '', 0, 'C');
        $this->pdf->cell($wCell, 0, $this->entrada['ejercicio']['almacen']['nombreResponsableAlmacen'], 'B', 1, 'C');
        
        $this->pdf->cell($wCell, 0, $this->entrada['ejercicio']['almacen']['cargoRecursosMateriales'], '', 0, 'C');
        $this->pdf->cell($wCell, 0, "", '', 0, 'C');
        $this->pdf->cell($wCell, 0, $this->entrada['ejercicio']['almacen']['cargoResponsableAlmacen'], '', 0, 'C');
        $yF = $this->pdf->GetY();
        
    }
}
