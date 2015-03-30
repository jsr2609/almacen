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
use AppBundle\Entity\Ejercicios;
use AppBundle\Inventarios\PEPS;

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
        } else {
            $precio = $entidad->getPrecio();
        }
        
        return $precio;
    }
    
    public function diferenciaCantidadesPEPS($cantidadNueva, $precioNuevo, $cantidadActual, $precioActual, $iva, $aplicaIva, $aplicaIvaActual)
    {
        
        if($aplicaIva) {
            $precioNuevo = round($precioNuevo + ($precioNuevo * ($iva / 100)), 2);
        }
        
        
        
        if($aplicaIvaActual) {
            $precioActual = round($precioActual + ($precioActual * ($iva / 100)), 2);
        }
        
        
        
        $diferenciaCantidad = $cantidadNueva - $cantidadActual;
        $totalNuevo = round($cantidadNueva * $precioNuevo, 2);
        
        $totalActual = round($cantidadActual * $precioActual, 2);
        $diferenciaTotal = round($totalNuevo - $totalActual, 2);
        
        
        
        return array(
            'cantidad' => $diferenciaCantidad,
            'total' => $diferenciaTotal,
        );
        
    }
    
    public function obtenerDiferencias($cantidadNueva, $precioNuevo, $cantidadActual, $precioActual, $tipoInventario) 
    {
        switch($tipoInventario) {
            case 1:
                $diferencias = $this->diferenciaCantidadesPEPS($cantidadNueva, $precioNuevo, $cantidadActual, $precioActual);
                break;
            default:
                $msgE = "No se ha definido el tipo de inventario ".$tipoInventario.
                    ", no es posible calcular las diferencias";
                throw new \LogicException($msgE);
        }
        
        return $diferencias;
        
    }
    
    
    public function actualizarExistencia(EntradaDetalles $detalle, $cantidadActual, 
        $precioActual, $ejercicio, Existencias $existencia, $aplicaIvaActual) 
    {
        $tipoInventario = $ejercicio['tipoInventario'];
        $iva = $ejercicio['iva'];
        
        switch($tipoInventario) {
            case 1:
                $diferencias = $this->diferenciaCantidadesPEPS($detalle->getCantidad(), $detalle->getPrecio(), 
                    $cantidadActual, $precioActual, $iva, $detalle->getAplicaIva(), $aplicaIvaActual
                );
                $existenciaDetalleActual = $detalle->getExistencia();
                $detalle->setExistencia($existenciaDetalleActual + $diferencias['cantidad']);
                $existenciaActual = $existencia->getCantidad();
                $totalActual = $existencia->getTotal();
                $existencia->setCantidad($existenciaActual + $diferencias['cantidad']);
                $existencia->setTotal($totalActual + $diferencias['total']);
                break;
            case 2:
                break;
            default:
                $msgE = "No se ha definido el tipo de inventario ".$tipoInventario.
                    ", no es posible actualizar la existencia del detalle";
                throw new \LogicException($msgE);
        }
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