<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Genera el PDF el alta
 *
 * @author jsr
 */


namespace AppBundle\PDF;

use AppBundle\Repository\EntradaDetallesRepository;
use AppBundle\PDF\AltasTCPDF;

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
     
    
    
    public function imprimirDetalles(EntradaDetallesrepository $edsRepository, $sumaIva)
    {
        $this->pdf->SetFont('helvetica', '', 7);
        
        $wCells = $this->pdf->getWCells();
        $hCell = 5;
        
        $this->pdf->SetFont('helvetica', '', 8);
        
        $partidas = $edsRepository->obtenerPartidasPorEntrada($this->entrada['id']);
        
        $selectEds = 'ats.clave, ats.nombre, ats.presentacionNombre, eds.fechaCaducidad, eds.cantidad, '
            . 'eds.precio, eds.aplicaIva';
        
        $total = 0;
        $iva = $this->entrada['ejercicio']['iva'];
        
        foreach($partidas as $partida) {
            $this->pdf->SetFont('helvetica', 'B', 7);
            $this->pdf->cell($wCells['wNombre'], $hCell, $partida['clave']." ".$partida['nombre'], '', 1, 'l');
            $this->pdf->Ln(1);
            $this->pdf->SetFont('helvetica', '', 6);
            
            $detalles = $edsRepository->buscarTodos($selectEds, $this->entrada['id'], $partida['id']);
            $subtotalPartida = 0;
            foreach($detalles as $detalle){
                $page = $this->pdf->getPage();
                $yI = $this->pdf->GetY();
                $nombre = $detalle['nombre'];
                //$this->pdf->getStringHeight($w, $txt, $reseth, $autopadding, $cellpadding, $border);
                
                //$hNombre = $this->pdf->getStringHeight($wCells['wNombre'], $nombre, true, true, 1, 'LTRB')+.6;
                $hNombre = $this->imprimirColumnaNombre($detalle['nombre'], $wCells['wNombre'], $wCells['wCve']);
                
                //Articulos
                
                $this->pdf->setPage($page);
                $this->pdf->SetX(PDF_MARGIN_LEFT);
                $this->pdf->SetY($yI);
                $this->pdf->MultiCell($wCells['wCve'], $hNombre, $detalle['clave'], 'LTRB', 'C', 0, 0, '', '', true, 0, true);
                //$this->pdf->MultiCell($w, $h, $txt, $border, $align, $fill, $ln, $x, $y, $reseth, $stretch, $ishtml, $autopadding, $maxh, $valign, $fitcell)
                
                $this->pdf->SetX(PDF_MARGIN_LEFT + $wCells['wCve'] + $wCells['wNombre']);

                $fechaCaducidad = ($detalle['fechaCaducidad'] === null) ? '' : $detalle['fechaCaducidad']->format('d/m/Y');
                $this->pdf->MultiCell($wCells['wCaducidad'], $hNombre, $fechaCaducidad, 'LTRB','C', 0, 0, '', '',true, 0, true);
                $this->pdf->MultiCell($wCells['wCantidad'], $hNombre, number_format($detalle['cantidad'], 0, '.', ','), 'LTRB', 'R', 0, 0, '', '',true, 0, true);
                $this->pdf->MultiCell($wCells['wUnidad'], $hNombre, $detalle['presentacionNombre'], 'LTRB', 'L', 0, 0, '', '',true, 0, true);
                $precio = $detalle['precio'];
                /*
                if($detalle['aplicaIva']) {
                    $precio = round($precio + ($precio * $iva / 100), 2);
                }
                 * 
                 */
                $this->pdf->MultiCell($wCells['wPrecio'], $hNombre, number_format($precio, 2, '.', ','), 'LTRB', 'R', 0, 0, '', '',true, 0, true);
                $importe = round($precio * $detalle['cantidad'], 2);
                
                $this->pdf->MultiCell($wCells['wImporte'], $hNombre, number_format($importe, 2, '.', ','), 'LTRB', 'R', 0, 1, '', '',true, 0, true);
                $subtotalPartida += $importe;
                
            }
            $this->pdf->SetFillColor(230, 230, 230);
            $subtotalPartida = round($subtotalPartida, 2);
            
            $this->pdf->cell($wCells['wCve'], $hCell, '', '', 0, 'C');
            $this->pdf->cell($wCells['wNombre'], $hCell, '', '', 0, 'L');
            $this->pdf->cell($wCells['wCaducidad'], $hCell, '', '', 0, 'C');
            $this->pdf->cell($wCells['wCantidad'], $hCell, '', '', 0, 'R');            
            $this->pdf->cell($wCells['wUnidad'] + $wCells['wPrecio'], $hCell, 'SUBTOTAL '.$partida['clave'], 'LTRB', 0, 'R', 1);                        
            $this->pdf->cell($wCells['wImporte'], $hCell, number_format($subtotalPartida, 2, '.', ','), 'LTRB', 1, 'R', 0);
            $total += $subtotalPartida;
        }
        
        $this->pdf->Ln(5);
        $total = round($total, 2);
        $this->pdf->SetFont('helvetica', 'B', 8);
        $yITotal = $this->pdf->GetY();
        $yLimitTotal = $this->pdf->getPageHeight() - $this->pdf->getBreakMargin();
        
        if($yLimitTotal - $yITotal < 15) {
            $this->pdf->AddPage();
        }
        $this->pdf->cell($wCells['wCve'], $hCell, '', '', 0, 'C');
        $this->pdf->cell($wCells['wNombre'], $hCell, '', '', 0, 'L');
        $this->pdf->cell($wCells['wCaducidad'], $hCell, '', '', 0, 'C');
        $this->pdf->cell($wCells['wCantidad'], $hCell, '', '', 0, 'R');
        $this->pdf->SetFillColor(230, 230, 230);

        $this->pdf->cell($wCells['wUnidad'] + $wCells['wPrecio'], $hCell, 'SUBTOTAL', 'LTRB', 0, 'R', 1);
        $this->pdf->cell(0, $hCell, number_format($total, 2, '.', ','), 'LTRB', 1, 'R', 0);
        
        $this->pdf->cell($wCells['wCve'], $hCell, '', '', 0, 'C');
        $this->pdf->cell($wCells['wNombre'], $hCell, '', '', 0, 'L');
        $this->pdf->cell($wCells['wCaducidad'], $hCell, '', '', 0, 'C');
        $this->pdf->cell($wCells['wCantidad'], $hCell, '', '', 0, 'R');
        $this->pdf->SetFillColor(230, 230, 230);
        $iva = ($sumaIva == true) ? $iva : 0;
        $totalIva = round($total * $iva/100, 2);
        $this->pdf->cell($wCells['wUnidad'] + $wCells['wPrecio'], $hCell, 'I.V.A', 'LTRB', 0, 'R', 1);
        $this->pdf->cell(0, $hCell, number_format($totalIva, 2, '.', ','), 'LTRB', 1, 'R', 0);
        
        $this->pdf->cell($wCells['wCve'], $hCell, '', '', 0, 'C');
        $this->pdf->cell($wCells['wNombre'], $hCell, '', '', 0, 'L');
        $this->pdf->cell($wCells['wCaducidad'], $hCell, '', '', 0, 'C');
        $this->pdf->cell($wCells['wCantidad'], $hCell, '', '', 0, 'R');
        $this->pdf->SetFillColor(230, 230, 230);

        $this->pdf->cell($wCells['wUnidad'] + $wCells['wPrecio'], $hCell, 'TOTAL', 'LTRB', 0, 'R', 1);
        $this->pdf->cell(0, $hCell, number_format($total + $totalIva, 2, '.', ','), 'LTRB', 1, 'R', 0);
        $yFTotal = $this->pdf->GetY();
        
        //die(var_export($yFTotal - $yITotal));
        /*
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
    
    private function imprimirColumnaNombre($txt, $w, $x)
    {
        // store current object
        
        // store starting values
        $this->pdf->setX(PDF_MARGIN_LEFT+$x);
        $start_y = $this->pdf->GetY();
        $start_page = $this->pdf->getPage();
        // call your printing functions with your parameters
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        $this->pdf->MultiCell($w, $h=6, $txt, $border=1, $align='L', $fill=false, $ln=1, $x='', $y='',     $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0);
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // get the new Y
        $end_y = $this->pdf->GetY();
        $end_page = $this->pdf->getPage();
        // calculate height
        $heightT = 0;
        $breakMargin = $this->pdf->getBreakMargin();
        $margins = $this->pdf->getMargins();
        $marginTop = $margins['top'];
        $pageHeight = $this->pdf->getPageHeight();
        
        if ($end_page == $start_page) {
            $heightT = $end_y - $start_y;
        } else {
            for ($page=$start_page; $page <= $end_page; ++$page) {
                
                $this->pdf->setPage($page);
                if ($page == $start_page) {
                    // first page
                    $height = $pageHeight - $start_y - $breakMargin;
                    
                } elseif ($page == $end_page) {
                    // last page
                    $height = $end_y - $marginTop;
                } else {
                    $height = $pageHeight - $marginTop - $breakMargin;
                }
                
                $heightT= $heightT + $height;
            }
        }
        
        return $heightT;
    }
    
    public function imprimirFirmas()
    {
        
        $margins = $this->pdf->getMargins();
        $pageW = $this->pdf->getPageWidth() - $margins['left'] - $margins['right'];
        $wCell = $pageW / 3;
        $yActual = $this->pdf->GetY();
        $hC = $this->pdf->getCellHeight($this->pdf->getFontSize());
        $iFirmas = $this->pdf->getPageHeight() - $this->pdf->getBreakMargin() - $hC * 3 - 5;
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
