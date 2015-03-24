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
use SSA\UtilidadesBundle\Manager\BaseManager;
use AppBundle\Entity\Articulos;
use AppBundle\Entity\Programas;
use AppBundle\Entity\Existencias;
use AppBundle\Entity\EntradaDetalles;

class EntradaDetallesManager 
{
    private $repository = "AppBundle:EntradaDetalles";
    private $base;
        
    public function __construct(BaseManager $base)
    {
        $this->base = $base;
    }
    
    public function calcularPrecio(EntradaDetalles $entidad)
    {
        if($entidad->getAplicaIva()) {
            $almacenDatos = $this->base->getSession()->get('almacen');
            $ejercicio = $this->base->getRepository("AppBundle:Ejercicios")->findOneBy(array(
                'almacen' => $almacenDatos['id'],
                'periodo' => $almacenDatos['ejercicio']['periodo'],
            ));
            $precio = $entidad->getPrecio() + ($entidad->getPrecio() * ($ejercicio->getIva()/100));
            die(var_export($precio));
        } else {
            $precio = $entidad->getPrecio();
        }
        
        return $precio;
    }
    
    /**
     * 
     * @return ExistenciasRepository
     */
    private function getRepository($repository =  null)
    {
        if($repository === null) {
            $repository = $this->repository;
        }
        
        return $this->base->getRepository($repository);
    }
    
}