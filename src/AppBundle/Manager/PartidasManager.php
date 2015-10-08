<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaseManager
 *
 * @author jsr by DTD
 */

namespace AppBundle\Manager;

use AppBundle\Entity\Programas;
use SSA\UtilidadesBundle\Manager\BaseManager;
use AppBundle\Entity\Partidas;


class PartidasManager 
{
    private $base; 
    private $repository = "AppBundle:Partidas";
    
        
    public function __construct(BaseManager $base)
    {
        $this->base = $base;
    }
    
    public function comprobarExistencias($partidas, $campo = 'clave')
    {
        $repository = $this->getRepository();
        foreach($partidas as $item) {
            $partida = $repository->findOneBy(array(
                $campo => $item['clave'],
            ));

            if(!$partida) {
                $em = $this->base->getManager();
                $partida = new Partidas();
                $partida->setClave($item['clave']);
                $partida->setNombre($item['nombre']);
                $em->persist($partida);
                $em->flush();
            }
        }
        
        
        return $this;
    }    
    
    
    /**
     * 
     * @param type $repository
     * @return ProveedoresRepository
     */
    private function getRepository($repository =  null)
    {
        if($repository === null) {
            $repository = $this->repository;
        }
        
        return $this->base->getRepository($repository);
    }
}