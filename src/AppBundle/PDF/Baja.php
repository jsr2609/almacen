<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\PDF;

use AppBundle\Repository\SalidaDetallesRepository;
use AppBundle\PDF\MyTCPDF;
use AppBundle\PDF\BajaTCPDF;
use SSA\UtilidadesBundle\Helper\Helpers;

/**
 * Description of Baja
 *
 * @author jsr by DTD
 */
class Baja
{
    private $pdf;
    private $salida;
    private $wCs;
    
    public function __construct(BajaTCPDF $pdf, $salida) 
    {
        $this->pdf = $pdf;
        $this->salida = $salida;
    }
     

 public function imprimirDetalles(SalidaDetallesrepository $sdsRepository)
    {
        $this->pdf->SetFont('helvetica', '', 7);
        
        $wCells = $this->pdf->getWCells();
        $hCell = 5;
        
        $this->pdf->SetFont('helvetica', '', 8);
        
        $partidas = $sdsRepository->obtenerPartidasPorSalida($this->salida['id']);
        
        
        $selectSds = 'ats.clave, ats.nombre, eds.fechaCaducidad, sds.cantidad, '
            . 'pss.nombre AS presentacionNombre, eds.precio, eds.aplicaIva';
        
        $total = 0;
        $iva = $this->salida['ejercicio']['iva'];
        
        foreach($partidas as $partida) {
            $this->pdf->SetFont('helvetica', 'B', 7);
            $this->pdf->cell($wCells['wNombre'], $hCell, $partida['clave']." ".$partida['nombre'], '', 1, 'l');
            $this->pdf->Ln(1);
            $this->pdf->SetFont('helvetica', '', 6);
            
            $detalles = $sdsRepository->buscarTodos($selectSds, $this->salida['id'], $partida['id']);
            $subtotalPartida = 0;
            foreach($detalles as $detalle){
                $page = $this->pdf->getPage();
                $yI = $this->pdf->GetY();
                $nombre = $detalle['nombre'];
                
                $hNombre = $this->imprimirColumnaNombre($detalle['nombre'], $wCells['wNombre'], $wCells['wCve']);
                
                //Articulos
                
                $this->pdf->setPage($page);
                $this->pdf->SetX(PDF_MARGIN_LEFT);
                $this->pdf->SetY($yI);
                $this->pdf->MultiCell($wCells['wCve'], $hNombre, $detalle['clave'], 'LTRB', 'C', 0, 0, '', '', true, 0, true);
               
                
                $this->pdf->SetX(PDF_MARGIN_LEFT + $wCells['wCve'] + $wCells['wNombre']);
                
                $fechaCaducidad = ($detalle['fechaCaducidad'] === null) ? '' : $detalle['fechaCaducidad']->format('d/m/Y');
                $this->pdf->MultiCell($wCells['wCaducidad'], $hNombre, $fechaCaducidad, 'LTRB','C', 0, 0, '', '',true, 0, true);
                $this->pdf->MultiCell($wCells['wCantidad'], $hNombre, number_format($detalle['cantidad'], 0, '.', ','), 'LTRB', 'R', 0, 0, '', '',true, 0, true);
                $this->pdf->MultiCell($wCells['wUnidad'], $hNombre, $detalle['presentacionNombre'], 'LTRB', 'C', 0, 0, '', '',true, 0, true);
                $precio = $detalle['precio'];
                /*
                if($detalle['aplicaIva']) {
                    $precio = round($precio + ($precio * $iva / 100), 2);
                }*/
                $this->pdf->MultiCell($wCells['wPrecio'], $hNombre, number_format($precio, 2, '.', ','), 'LTRB', 'R', 0, 0, '', '',true, 0, true);
                $importe = round($precio * $detalle['cantidad'], 2);
                
                $this->pdf->MultiCell($wCells['wImporte'], $hNombre, number_format($importe, 2, '.', ','), 'LTRB', 'R', 0, 1, '', '',true, 0, true);
                $subtotalPartida += $importe;
                
            }
            $subtotalPartida = round($subtotalPartida, 2);
            
            $this->pdf->cell($wCells['wCve'], $hCell, '', '', 0, 'C');
            $this->pdf->cell($wCells['wNombre'], $hCell, '', '', 0, 'L');
            $this->pdf->cell($wCells['wCaducidad'], $hCell, '', '', 0, 'C');
            $this->pdf->cell($wCells['wCantidad'], $hCell, '', '', 0, 'R');            
            $this->pdf->cell($wCells['wUnidad'] + $wCells['wPrecio'], $hCell, 'SUBTOTAL '.$partida['clave'], '', 0, 'R');                        
            $this->pdf->cell($wCells['wImporte'], $hCell, number_format($subtotalPartida, 2, '.', ','), 'LTRB', 1, 'R', 0);
            $total += $subtotalPartida;
        }
        
        $this->pdf->Ln(3);
        $total = round($total, 2);
        $this->pdf->SetFont('helvetica', 'B', 8);
        
        $this->pdf->cell($wCells['wCve'], $hCell, '', '', 0, 'C');
        $this->pdf->cell($wCells['wNombre'], $hCell, '', '', 0, 'L');
        $this->pdf->cell($wCells['wCaducidad'], $hCell, '', '', 0, 'C');
        $this->pdf->cell($wCells['wCantidad'], $hCell, '', '', 0, 'R');
        $this->pdf->SetFillColor(230, 230, 230);

        $this->pdf->cell($wCells['wUnidad'] + $wCells['wPrecio'], $hCell, 'SUBTOTAL', 'LTRB', 0, 'R', 1);
        $this->pdf->cell($wCells['wImporte'], $hCell, number_format($total, 2, '.', ','), 'LTRB', 1, 'R', 0);
        
        $this->pdf->cell($wCells['wCve'], $hCell, '', '', 0, 'C');
        $this->pdf->cell($wCells['wNombre'], $hCell, '', '', 0, 'L');
        $this->pdf->cell($wCells['wCaducidad'], $hCell, '', '', 0, 'C');
        $this->pdf->cell($wCells['wCantidad'], $hCell, '', '', 0, 'R');
        $this->pdf->SetFillColor(230, 230, 230);
        
        $iva = round($total * $iva/100, 2);
        $this->pdf->cell($wCells['wUnidad'] + $wCells['wPrecio'], $hCell, 'I.V.A', 'LTRB', 0, 'R', 1);
        $this->pdf->cell($wCells['wImporte'], $hCell, number_format($iva, 2, '.', ','), 'LTRB', 1, 'R', 0);
        
        $this->pdf->cell($wCells['wCve'], $hCell, '', '', 0, 'C');
        $this->pdf->cell($wCells['wNombre'], $hCell, '', '', 0, 'L');
        $this->pdf->cell($wCells['wCaducidad'], $hCell, '', '', 0, 'C');
        $this->pdf->cell($wCells['wCantidad'], $hCell, '', '', 0, 'R');
        $this->pdf->SetFillColor(230, 230, 230);

        $this->pdf->cell($wCells['wUnidad'] + $wCells['wPrecio'], $hCell, 'TOTAL', 'LTRB', 0, 'R', 1);
        $this->pdf->cell($wCells['wImporte'], $hCell, number_format($total + $iva, 2, '.', ','), 'LTRB', 1, 'R', 0);
        
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
        $this->pdf->MultiCell($w, $h=5, $txt, $border=1, $align='L', $fill=false, $ln=1, $x='', $y='',     $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0);
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
  
    
     public function imprimirFirmasdeSalida()
    {
        $margins = $this->pdf->getMargins();
        $pageW = $this->pdf->getPageWidth() - $margins['left'] - $margins['right'];
        $wCell = $pageW / 3;
        $yActual = $this->pdf->GetY();
        $hC = $this->pdf->getCellHeight($this->pdf->getFontSize());
        $iFirmas = $this->pdf->getPageHeight() - $this->pdf->getBreakMargin() - $hC * 6 -5;
        
        if($yActual < $iFirmas) {
            $this->pdf->SetY($iFirmas);
            
        } else {
            $this->pdf->AddPage();
            $this->pdf->SetY($iFirmas);
        }
        $this->pdf->cell(0, 0, '', '', 1, 'C');
        $yI = $this->pdf->GetY();
        
        $this->pdf->cell($wCell, 0, $this->salida['nombreQuienRecibe'], 'B', 0, 'C');
        $this->pdf->cell($wCell, 0, "", '', 0, 'C');
        $this->pdf->cell($wCell, 0, "", 'B', 1, 'C');
        
        $this->pdf->cell($wCell, 0, 'RECIBI DE CONFORMIDAD', '', 0, 'C');
        $this->pdf->cell($wCell, 0, "", '', 0, 'C');
        $this->pdf->cell($wCell, 0, "DESPACHO", '', 1, 'C');
        
        $this->pdf->cell(0, 0, '', '', 1, 'C');
        
        $this->pdf->cell($wCell, 0, "", '', 0, 'C');
        $this->pdf->cell($wCell, 0, $this->salida['ejercicio']['almacen']['nombreResponsableAlmacen'], 'B', 0, 'C');
        $this->pdf->cell($wCell, 0, "", '', 1, 'C');
        
        $this->pdf->cell($wCell, 0, '', '', 0, 'C');
        $this->pdf->cell($wCell, 0, $this->salida['ejercicio']['almacen']['cargoResponsableAlmacen'], '', 0, 'C');
        $this->pdf->cell($wCell, 0, '', '', 0, 'C');
        
        
        $yF = $this->pdf->GetY();
        
    }
}
