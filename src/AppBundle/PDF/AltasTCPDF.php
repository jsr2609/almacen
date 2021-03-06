<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * TCPDF para formato base de altas
 *
 * @author jsr
 */

namespace AppBundle\PDF;

use AppBundle\PDF\MyTCPDF;
use SSA\UtilidadesBundle\Helper\DateToText;


/**
 * Description of MyTCPDF
 *
 * @author jsr
 */
class AltasTCPDF extends MyTCPDF
{
    private $footerText = array('address' => '', 'telephones' => '');
    /**
     * Los datos de a entrada en un arreglo
     * 
     * @var array 
     */
    private $entrada;
    
    private $wCells;
    
    
    public function setFooterText(array $txt)
    {
        $this->footerText = $txt;
    }
    
    public function Header()
    {
        if ($this->header_xobjid === false) {
            
        $this->header_xobjid = $this->startTemplate($this->w, $this->tMargin);
        $headerfont = $this->getHeaderFont();
        $headerdata = $this->getHeaderData();
        $this->y = $this->header_margin;
        
        
        //Colocando imagen secundaria
        if ($this->rtl) {
                $this->x = $this->w - $this->original_rMargin;
        } else {
                $this->x = $this->original_lMargin;
        }
       
        $this->Image(K_PATH_IMAGES.$headerdata['logo'], '', '', $headerdata['logo_width']);
        $imgly = $this->getImageRBY();
        $cell_height = $this->getCellHeight($headerfont[2] / $this->k);
        if ($this->getRTL()) {
                $header_x = $this->original_rMargin + ($headerdata['logo_width'] * 1.1);
        } else {
                $header_x = $this->original_lMargin + ($headerdata['logo_width'] * 1.1);
        }
        $this->setX($header_x);
        $cw = $this->w - $this->original_lMargin - $this->original_rMargin - ($headerdata['logo_width'] * 1.1) - ($headerdata['logo_width'] * 1.1);
        
        $this->SetFont($headerfont[0], 'B', 9);
        $this->setX($header_x);
        
        $this->Cell($cw, $cell_height, $headerdata['title'], '', 1, 'C', 0, '', 0);
        $this->SetFont($headerfont[0], $headerfont[1], 9);
        $this->SetX($header_x);
        $this->MultiCell($cw, $cell_height, $headerdata['string'], 0, 'C', 0, 1);
        
        $this->SetLineStyle(array('width' => 0.85 / $this->k, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $headerdata['line_color']));
        
	$this->SetY((2.835 / $this->k) + max($imgly, $this->y));
        //Imprimiendo la linea de final de encabezado
        $this->SetTextColorArray(array(88,88,90));
        if ($this->rtl) {
                $this->x = $this->w - $this->original_rMargin;
        } else {
                $this->x = $this->original_lMargin;
        }
        $this->Cell(($this->w - $this->original_lMargin - $this->original_rMargin), 0, 'Juntas Y Juntos Podemos', 'B', 1, 'R');
        $this->imprimirDatos();
        
        $this->endTemplate();
        }
        // print header template
		$x = 0;
		$dx = 0;
		if (!$this->header_xobj_autoreset AND $this->booklet AND (($this->page % 2) == 0)) {
			// adjust margins for booklet mode
			$dx = ($this->original_lMargin - $this->original_rMargin);
                        
		}
		if ($this->rtl) {
			$x = $this->w + $dx;
                        
		} else {
                    
			$x = 0 + $dx;
		}
                
		$this->printTemplate($this->header_xobjid, $x, 0, 0, 0, '', '', false);
		if ($this->header_xobj_autoreset) {
			// reset header xobject template at each page
			$this->header_xobjid = false;
		}
        
    }
    
    public function imprimirDatos()
    {    
        
        $this->SetMargins(PDF_MARGIN_LEFT, 90, PDF_MARGIN_RIGHT);
        $this->Ln(2);
        $this->SetFont('helvetica', 'B', 9);
        $this->SetTextColorArray(array(0,0,0));
        $this->Cell(0, 0, 'AVISO DE ALTA', '', 1, 'C');
        //$this->Cell($w, $h, $txt, $border, $ln, $align, $fill, $link, $stretch, $ignore_min_height)
        $this->Ln(5);
        $yFolio = $this->GetY();
        //$this->Text($x, $y, $txt, $fstroke, $fclip, $ffill, $border, $ln, $align, $fill)
        $this->SetFont('helvetica', 'B', 14);
        $this->SetTextColor(195, 41, 0);
        $this->Text(PDF_MARGIN_LEFT, $yFolio, 'Folio '.$this->entrada['folio'], false, false, true, '', 0, 'R');
        $this->SetFont('helvetica', '', 10);
        $this->Text(PDF_MARGIN_LEFT, $yFolio + 5, $this->entrada['folioManual'], false, false, true, '', 0, 'R');
        $this->SetY($yFolio+5);
        $this->SetFont('helvetica', '', 9);
        $this->SetTextColor(0, 0, 0);
        $dateToText = new DateToText($this->entrada['fecha']);
        $lugar = $this->entrada['ejercicio']['almacen']['lugar']." A ".strtoupper($dateToText->getText());
        $this->Cell(0, 0, $lugar, '', 1, 'L');
        $this->Cell(0, 0, mb_strtoupper($this->entrada['ejercicio']['almacen']['nombreJefeServicios'], 'UTF-8'), '', 1, 'L');
        $this->Cell(0, 0, 'CON ESTA FECHA SE DAN DE ALTA PROCEDENTES DE:', '', 1, 'L');
        $this->Cell(0, 0, mb_strtoupper($this->entrada['proveedor']['nombre'], 'UTF-8'), '', 1, 'L');
        $fechaFactura = ($this->entrada['facturaFecha'] == null) ? "" : $this->entrada['facturaFecha']->format('d/m/Y');
        $datosFactura = 'SEGUN FACTURA '.$this->entrada['facturaNumero'].', DE FECHA '.$fechaFactura
            .', NÚMERO DE PEDIDO '.$this->entrada['pedidoNumero'];
        $this->Cell(0, 0, $datosFactura, '', 1, 'L');
        $programa = $this->entrada['programa']['clave'].'-'.$this->entrada['programa']['nombre'];
        $this->Cell(0, 0, 'PROGRAMA: '.$programa, '', 1, 'L');
        $this->Cell(0, 0, 'OBSERVACIONES: '.mb_strtoupper($this->entrada['observaciones'], 'UTF-8'), '', 1, 'L');
        $this->Cell(0, 0, 'LOS ARTICULOS QUE ACONTINUACIÓN SE DETALLAN:', '', 1, 'L');
        $this->Ln(5);
        
        $this->SetFillColor(230, 230, 230);
        
        
        $this->cell($this->wCells['wCve'], 5, 'CLAVE', 'LTRB', 0, 'C', 1);
        $this->cell($this->wCells['wNombre'], 5, 'NOMBRE', 'LTRB', 0, 'C', 1);
        $this->cell($this->wCells['wCaducidad'], 5, 'CAD.', 'LTRB', 0, 'C', 1);
        $this->cell($this->wCells['wCantidad'], 5, 'CANT.', 'LTRB', 0, 'C', 1);
        $this->cell($this->wCells['wUnidad'], 5, 'UNIDAD', 'LTRB', 0, 'C', 1);
        $this->cell($this->wCells['wPrecio'], 5, 'PRECIO', 'LTRB', 0, 'C', 1);
        $this->cell($this->wCells['wImporte'], 5, 'IMPORTE', 'LTRB', 1, 'C', 1);
        
        
   }
    
    public function Footer() {
        
		$cur_y = $this->y;
                $this->setFooterData(array(88,88,90), array(0,0,0));
		$this->SetTextColorArray($this->footer_text_color);
		//set style for cell border
		$line_width = (0.85 / $this->k);
		//$this->SetLineStyle(array('width' => $line_width, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $this->footer_line_color));
		//print document barcode
		
                // QRCODE,H : QR-CODE Best error correction
                //$this->Cell(0, 0, '', 'T', 1, 'L');
                
		$w_page = isset($this->l['w_page']) ? $this->l['w_page'].' ' : '';
		if (empty($this->pagegroups)) {
			$pagenumtxt = $w_page.$this->getAliasNumPage().' / '.$this->getAliasNbPages();
		} else {
			$pagenumtxt = $w_page.$this->getPageNumGroupAlias().' / '.$this->getPageGroupAlias();
		}
		$this->SetY($cur_y);
                
		$this->SetX($this->original_lMargin);
                        
                $this->Cell(0, 0, $this->getAliasRightShift().$pagenumtxt."", 'T', 1, 'R');
                $this->write2DBarcode($this->entrada['folio'], 'QRCODE,H', '', '', 10, 10);
                $this->SetX($this->original_lMargin + 15);
                $domicilio = 'Av. Ruffo Figueroa #6, Col.Burocratas, C.P. 39020, Chilpancingo, Gro.';
                
                $this->Cell(0, 0, $this->footerText['address'], '', 1, '');
                $this->SetX($this->original_lMargin + 15);
                $this->Cell(0, 0, $this->footerText['telephones'], '', 1, '');
                
	}
    
    
    public function init($entrada, $footerText = null)
    {
        $this->entrada = $entrada;
        
        $nombreAlmacen = $entrada['ejercicio']['almacen']['nombre'];
        if($footerText){
            $this->setFooterText($footerText);
        }
        //Asignando wl ancho de las celdas
        $this->wCells = array(
            'wCve' => 17,
            'wNombre' => 89,
            'wCaducidad' => 15,
            'wCantidad' => 15,
            'wUnidad' => 20,
            'wPrecio' => 20,
            'wImporte' => 20,
        );
        
        
        
        $this->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, 
            mb_strtoupper($nombreAlmacen, 'UTF-8')
        );
        $this->setFooterData(array(0,64,0), array(0,64,128));
        // set header and footer fonts
        $this->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $this->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        
        $breakMargin = 20.8;
        
        $this->SetMargins(PDF_MARGIN_LEFT, 87, PDF_MARGIN_RIGHT);
        $this->SetHeaderMargin(PDF_MARGIN_HEADER);
        $this->SetFooterMargin($breakMargin);
        
        
        // set auto page breaks
        $this->SetAutoPageBreak(TRUE, $breakMargin);
        
        $this->AddPage();
    }
    
    public function getWCells()
    {
        return $this->wCells;
    }
    
}
