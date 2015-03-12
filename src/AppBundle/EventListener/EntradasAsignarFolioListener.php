<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\EventListener;
use AppBundle\Event\EntradasEvent;

/**
 * Description of EntradasAsignarFolioListener
 *
 * @author jsr
 */
class EntradasAsignarFolioListener 
{
    private $entradasManager;
    
    public function __construct()
    {
        
    }
    
    public function onEntradasSubmitted(EntradasEvent $event)
    {
        $entrada = $event->getEntrada();
        die('Asignando folio');
    }
}
