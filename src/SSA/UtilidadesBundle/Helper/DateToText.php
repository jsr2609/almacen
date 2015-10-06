<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConvertirCantidadALetra
 *
 * @author jsr
 */
namespace SSA\UtilidadesBundle\Helper;

class DateToText
{
    
    private $date;
    private $dayWeek;
    private $dayMonth;
    private $month;
    private $year;
    
    public function __construct(\DateTime $date = null) {
        if($date != null) {
            
            $this->init($date);
        }
    }
    
    public function init(\DateTime $date) 
    {
        if(!$date) {
            $date = new \DateTime();
        }
        $this->date = $date;
        $this->dayWeek = $date->format('w');
        $this->dayMonth = $date->format('d');
        $this->month = $date->format('n');
        $this->year = $date->format('Y');
    }
    
    public function getText(\DateTime $date = null, $format = 1) 
    {
        if($date != null) {
            $this->init($date);
        }
        $nameDay = $this->getNameDay();
        $nameMonth = $this->getNameMonth();
        
        switch ($format) {
            case 1:
                $text = "$this->dayMonth de $nameMonth de $this->year";
                break;
            case 2:
                $text = "$nameDay $this->dayMonth de $nameMonth de $this->year";
                break;
            default:
                throw new \LogicException("No se encuentra definido este formato para convertir la fecha");
        }
        
        
        return $text;
    }
    
    private function getNameDay()
    {
        $days = array("Domingo","Lunes", "Mártes", "Miercoles", "Jueves", "Viernes", "Sabado");
        
        return $days[$this->dayWeek];
        
    }
    
    private function getNameMonth()
    {
        $months =array("","Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        
        return $months[$this->month];
        
    }
    
    
}
