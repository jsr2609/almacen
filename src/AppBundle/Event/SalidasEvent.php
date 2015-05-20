<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use AppBundle\Entity\Salidas;

/**
 * Description of SalidasEvent
 *
 * @author jsr by DTD
 */
class SalidasEvent extends Event
{
    private $salida;
    
    public function __construct(Salidas $salida)
    {
        $this->salida = $salida;
    }
    
    /**
     * 
     * @return Salidas
     */
    public function getSalida()
    {
        return $this->salida;
    }
}
