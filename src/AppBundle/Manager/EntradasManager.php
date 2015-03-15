<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaseManager
 *
 * @author jsr
 */

namespace SSA\UtilidadesBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ORM\Repository;
use AppBundle\Entity\Entradas;
use SSA\UtilidadesBundle\Manager\BaseManager;


class EntradasManager 
{
    private $base;
    private $repository = "AppBundle:Entradas";
        
    public function __construct(BaseManager $base)
    {
        $this->base = $this->base;
    }
    
    public function generarFolio( )
    {
        $this->getRepository();
    }
    
    private function getRepository($repository =  null)
    {
        if($repository === null) {
            $repository = $this->repository;
        }
        
        return $this->base->getRepository();
    }
    
}