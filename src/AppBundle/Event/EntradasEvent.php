<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use AppBundle\Entity\Entradas;

/**
 * Description of EntradasEvent
 *
 * @author jsr
 */
class EntradasEvent extends Event
{
    private $entrada;
    
    public function __construct(Entradas $entrada)
    {
        $this->entrada = $entrada;
    }
    
    /**
     * 
     * @return Entradas
     */
    public function getEntrada()
    {
        return $this->entrada;
    }
}
