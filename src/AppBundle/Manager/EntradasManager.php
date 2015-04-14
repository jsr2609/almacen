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

namespace AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ORM\Repository;
use AppBundle\Entity\Entradas;
use AppBundle\Repository\EntradasRepository;
use SSA\UtilidadesBundle\Manager\BaseManager;


class EntradasManager 
{
    private $base;
    private $repository = "AppBundle:Entradas";
        
    public function __construct(BaseManager $base)
    {
        $this->base = $base;
    }
    
    public function generarFolio( )
    {
        $this->getRepository();
    }
    
    /**
     * 
     * @param type $repository
     * @return EntradasRepository
     */
    private function getRepository($repository =  null)
    {
        if($repository === null) {
            $repository = $this->repository;
        }
        
        return $this->base->getRepository($repository);
    }
    
    public function comprobarEdicion(Entradas $entrada)
    {
        $editable = true;
        $mensaje = ""; 
        
        if($entrada->getValidada()) {
            $editable = false;
            $mensaje = "La entrada ya fue validada, no es posible la edición.";
        } else {
            $repository = $this->getRepository();
        
            $cantidad = $repository->contarEnSalidas($entrada->getId());
            if($cantidad > 0) {
                $editable = false;
                $mensaje = "Ya existen salidas de esta entrada, no es posible la edición.";
            }
        }
        
        return array(
            'editable' => $editable,
            'mensaje'  => $mensaje,
        );
    }
    
    public function obtenerRegistrosDT($repositorio, $peticion, $columnas, $cExtra = array(),
        $nombreFF = null, $cFiltros = null
    ) {
        
    }
    
}