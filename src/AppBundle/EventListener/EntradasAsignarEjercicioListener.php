<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\EventListener;
use AppBundle\Event\EntradasEvent;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bridge\Doctrine\RegistryInterface;
/**
 * Description of EntradasAsignarFolioListener
 *
 * @author jsr
 */
class EntradasAsignarEjercicioListener 
{
    
    private $session;
    private $registry;
    
    public function __construct(RegistryInterface $registry, Session $session)
    {
        $this->registry = $registry;
        $this->session = $session;
    }
    
    
    public function onEntradasSubmitted(EntradasEvent $event)
    {
        $entrada = $event->getEntrada();
        $em = $this->registry->getManager();
        $almacenDatos = $this->session->get('almacen');
        $ejercicio = $em->getRepository("AppBundle:Ejercicios")->findOneBy(array(
            'almacen' => $almacenDatos['id'],
            'periodo' => $almacenDatos['ejercicio']['periodo'],
        ));
        $entrada->setEjercicio($ejercicio);
        
    }
}
