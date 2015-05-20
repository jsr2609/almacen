<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\EventListener;
use AppBundle\Event\SalidasEvent;
use Symfony\Component\Security\Core\SecurityContext;
/**
 * Description of SalidasAsignarFolioListener
 *
 * @author jsr by DTD
 */
class SalidasAsignarUsuarioListener 
{
    
    private $securityContext;
    
    public function __construct(SecurityContext $securityContext)
    {        
        $this->securityContext = $securityContext;
    }
    
    
    public function onEntradasSubmitted(SalidasEvent $event)
    {
        $usuario = $this->securityContext->getToken()->getUser();
        $salida = $event->getSalida();
        $salida->setUsuario($usuario);
       
    }
}
