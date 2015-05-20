<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\EventListener;
use AppBundle\Event\SalidasEvent;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bridge\Doctrine\RegistryInterface;
/**
 * Description of SalidasAsignarFolioListener
 *
 * @author jsr by DTD
 */
class SalidasAsignarEjercicioListener 
{
    
    private $session;
    private $registry;
    
    public function __construct(RegistryInterface $registry, Session $session)
    {
        $this->registry = $registry;
        $this->session = $session;
    }
    
    
    public function onSalidasSubmitted(SalidasEvent $event)
    {
        $salida = $event->getSalida();
        $em = $this->registry->getManager();
        $almacenDatos = $this->session->get('almacen');
        $ejercicio = $em->getRepository("AppBundle:Ejercicios")->findOneBy(array(
            'almacen' => $almacenDatos['id'],
            'periodo' => $almacenDatos['ejercicio']['periodo'],
        ));
        $salida->setEjercicio($ejercicio);
        
    }
}
