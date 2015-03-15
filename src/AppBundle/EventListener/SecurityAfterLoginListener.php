<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\EventListener;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Description of s
 *
 * @author jsr
 */
class SecurityAfterLoginListener
{
    private $security;
    private $session;
    private $registry;
    
    public function __construct(SecurityContextInterface $security, Session $session, RegistryInterface $registry)
    {
      $this->security = $security;
      $this->session = $session;
      $this->registry = $registry;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $em = $this->registry->getManager();
        $user = $event->getAuthenticationToken()->getUser();
        $almacen = $user->getPerfil()->getAlmacen();
        
        $ejercicio = $em->getRepository('AppBundle:Ejercicios')->findOneBy(array(
            'almacen' => $almacen->getId(),
            'periodo' => date('Y'),
        ));
        
        if(!$ejercicio) {
            $this->session->getFlashBag()->add('danger', 'No existe un ejercicio definido para este año.');
            $ejercicioDatos = array('id' => null, 'periodo' => 'No se ha definido');
        } else {
            $ejercicioDatos = array('id' => $ejercicio->getId(), 'periodo' => $ejercicio->getPeriodo());
        }
        
        
        
        $almacenDatos = array(
            'id' => $almacen->getId(), 
            'nombre' => $almacen->getNombre(),
            'ejercicio' => $ejercicioDatos,
        );
        
        $this->session->set('almacen', $almacenDatos);
    }
}
