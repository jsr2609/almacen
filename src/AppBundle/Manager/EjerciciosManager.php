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

use SSA\UtilidadesBundle\Manager\BaseManager;
use AppBundle\Entity\Ejercicios;
use AppBundle\Repository\EjerciciosRepository;


class EjerciciosManager 
{
    private $repository = "AppBundle:Ejercicios";
    private $rootAlias = 'ecs';
    private $base;
        
    public function __construct(BaseManager $base)
    {
        $this->base = $base;
    }
    
    /**
     * 
     * @return Ejercicios
     */
    public function buscar($ejercicioDatos = null) 
    {
        if($ejercicioDatos) {
            $almacenId = $ejercicioDatos['almacen'];
            $periodo = $ejercicioDatos['periodo'];
        } else {
            $almacenDatos = $this->base->getSession()->get('almacen');
            $almacenId = $almacenDatos['id'];
            $periodo = $almacenDatos['ejercicio']['periodo'];
        }
        
        $ejercicio = $this->base->getRepository("AppBundle:Ejercicios")->findOneBy(array(
            'almacen' => $almacenId,
            'periodo' => $periodo,
        ));
        
        return $ejercicio;
    }
    
    public function buscarPorAlmacenYPeriodo($ejercicioDatos = null, $select = null, $hydrationMode = 'HYDRATE_OBJECT',  $root = null)
    {
        if($ejercicioDatos) {
            $almacenId = $ejercicioDatos['almacen'];
            $periodo = $ejercicioDatos['periodo'];
        } else {
            $almacenDatos = $this->base->getSession()->get('almacen');
            $almacenId = $almacenDatos['id'];
            $periodo = $almacenDatos['ejercicio']['periodo'];
        }
        $repository = $this->getRepository();
        $ejercicio = $repository->buscarPorAlmacenYPeriodo($almacenId, 
            $periodo, $select, $hydrationMode, $this->rootAlias
        );
        
        return $ejercicio;
        
    }
    
    public function agregarRootAliasSelect($select)
    {
        $collection = \explode(',', $select);
        
        for($i = 0; $i < count($collection); $i++) {
            $collection[$i] = $this->rootAlias.".".trim($collection[$i]);
        }
        
        $string = implode(",", $collection);
        
        return $string;
    }
    
    /**
     * 
     * @return EjerciciosRepository
     */
    public function getRepository()
    {
        return $repository = $this->base->getRepository($this->repository);
    }
    
    public function obtenerTipoInventario($ejercicioDatos = null)
    {
        $ejercicio = $this->buscar($ejercicioDatos);
        return $ejercicio->getTipoInventario();
    }
    
    public function obtenerIVAPorAlmacenYPeriodo($almacen = null, $periodo = null)
    {
        $datos = $this->base->getSession()->get('almacen');
        if(!$almacen) {
            $almacen = $datos['id'];
        }
        if(!$periodo) {
            $periodo = $datos['ejercicio']['periodo'];
        }
        
        $repository = $this->getRepository();
        
        $iva = $repository->obtenerIVAPorAlmacenYPeriodo($almacen, $periodo);
        
        return $iva;
    }
    
}