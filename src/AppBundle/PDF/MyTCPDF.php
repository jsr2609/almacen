<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\PDF;

use \TCPDF;

/**
 * Description of MyTCPDF
 *
 * @author jsr
 */
class MyTCPDF extends \TCPDF 
{
    private $footerText = array('address' => '', 'telephones' => '');
    
    
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
        
        $this->SetFont($headerfont[0], 'B', $headerfont[2] + 1);
        $this->setX($header_x);
        $this->Cell($cw, $cell_height, $headerdata['title'], '', 1, 'C', 0, '', 0);
        $this->SetFont($headerfont[0], $headerfont[1], $headerfont[2]);
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
        $this->Cell(($this->w - $this->original_lMargin - $this->original_rMargin), 0, 'Juntas Y Juntos Podemos', 'B', 0, 'R');
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
    
    public function Footer() {
        
		$cur_y = $this->y;
                $this->setFooterData(array(88,88,90), array(0,0,0));
		$this->SetTextColorArray($this->footer_text_color);
		//set style for cell border
		$line_width = (0.85 / $this->k);
		$this->SetLineStyle(array('width' => $line_width, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $this->footer_line_color));
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
                $this->write2DBarcode('www.tcpdf.org', 'QRCODE,H', '', '', 10, 10);
                $this->SetX($this->original_lMargin + 15);
                $domicilio = 'Av. Ruffo Figueroa #6, Col.Burocratas, C.P. 39020, Chilpancingo, Gro.';
                
                $this->Cell(0, 0, $this->footerText['address'], '', 1, '');
                $this->SetX($this->original_lMargin + 15);
                $this->Cell(0, 0, $this->footerText['telephones'], '', 1, '');
                
	}
    
}
