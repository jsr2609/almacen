<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\EventListener;
use AppBundle\Event\EntradasEvent;
use Symfony\Component\Security\Core\SecurityContext;
/**
 * Description of EntradasAsignarFolioListener
 *
 * @author jsr
 */
class EntradasAsignarUsuarioListener 
{
    
    private $securityContext;
    
    public function __construct(SecurityContext $securityContext)
    {        
        $this->securityContext = $securityContext;
    }
    
    
    public function onEntradasSubmitted(EntradasEvent $event)
    {
        $usuario = $this->securityContext->getToken()->getUser();
        $entrada = $event->getEntrada();
        $entrada->setUsuario($usuario);
       
    }
}
