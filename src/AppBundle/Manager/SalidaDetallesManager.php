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

use Doctrine\ORM\EntityManager;
use SSA\UtilidadesBundle\Manager\BaseManager;
use AppBundle\Entity\Articulos;
use AppBundle\Entity\Programas;
use AppBundle\Entity\Existencias;
use AppBundle\Entity\SalidaDetalles;
use AppBundle\Entity\EntradaDetalles;
use AppBundle\Entity\Ejercicios;
use AppBundle\Inventarios\PEPS;

class SalidaDetallesManager 
{
    private $repository = "AppBundle:SalidaDetalles";
    private $base;
        
    public function __construct(BaseManager $base)
    {
        $this->base = $base;
    }
          
    public function calcularPrecio($precio, $iva, $aplicaIva)
    {
        if($aplicaIva) {
            $precioNuevo = round($precio + ($precio * ($iva / 100)), 2);
        } else {
            $precioNuevo = $precio;
        }
        
        return $precioNuevo;
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
                
                $detalle->setExistencia($existenciaDetalleActual - $detalle->getCantidad());
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
    
    public function actualizarExistenciaSDS(SalidaDetalles $detalle, $cantidadActual, 
        $precioActual, $ejercicio, Existencias $existencia, $aplicaIvaActual) 
    {
        $tipoInventario = $ejercicio['tipoInventario'];
        $iva = $ejercicio['iva'];
        
        switch($tipoInventario) {
            case 1:
                $diferencias = $this->diferenciaCantidadesPEPS($detalle->getCantidad(), $detalle->getEntradaDetalle()->getPrecio(), 
                    $cantidadActual, $precioActual, $iva, $detalle->getEntradaDetalle()->getAplicaIva(), $aplicaIvaActual
                );
                
                $existenciaDetalleActual = $detalle->getEntradaDetalle()->getExistencia();
                
                $detalle->getEntradaDetalle()->setExistencia($existenciaDetalleActual - $detalle->getCantidad());
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
    
    
    public function listaArticulosPorSalida($salidaId, $iva)
    {
        $repository = $this->base->getRepository("AppBundle:SalidaDetalles");
        
        $select = "sds.id, sds.cantidad as cantidadSds, ats.clave as articuloClave, ats.nombre as articuloNombre, eds.cantidad, eds.precio, eds.aplicaIva";
        $articulos = $repository->buscarTodos($select, $salidaId);
        
        for($i = 0; $i < count($articulos); $i++) {
            $precio = $articulos[$i]['precio'];
            $aplicaIva = $articulos[$i]['aplicaIva'];
            
            if($aplicaIva) {
                $precio = $precio + ($precio * ($iva / 100));
            }
            
            $articulos[$i]['precio'] = round($precio, 2);
       
        }
        return $articulos;
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
    
    public function procesarArticulosDeEntradaDirecta($articulos, Salidas $salida, $ejercicio, ExistenciasManager $existenciasManager)
    {
        $em = $this->base->getManager();
        $articulosRepository = $em->getRepository("AppBundle:Articulos");
        foreach($articulos as $articulo)
        {
            $eds = new EntradaDetalles();
            $eds->setCantidad($articulo['cantidad']);
            $eds->setPrecio($articulo['precio']);
            $eds->setEntrada($entrada);
            $articuloObj = $articulosRepository->findOneBy(array('clave' => $articulo['clave']));
            if(!$articuloObj) {
                throw $this->base->createNotFoundException("No se encontró un articulo con la clave ".$articulo['clave']);
            }
            $eds->setArticulo($articuloObj);
            $eds->setExistencia($articulo['cantidad']);
            
            $em->persist($eds);
            
            $existenciasManager->aumentar($articuloObj, 
                $eds->getEntrada()->getPrograma(),
                $eds->getCantidad(), 
                $eds->getPrecio(),
                $ejercicio,
                $eds->getAplicaIva()
            );
            
            
            
        }
        
        $em->flush();
    }
    
}