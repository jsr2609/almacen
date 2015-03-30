<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Inventarios;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Existencias;
use AppBundle\Entity\Programas;
use AppBundle\Entity\Articulos;

/**
 * Description of PEPS
 *
 * @author jsr
 */
class PEPS 
{
    
    
    public function __construct()
    {
        
    }
    /**
     * Aumenta la cantidad de existencias de un artículo
     * 
     * @param object $articulo Id del Artículo
     * @param object $progama Id del Programa
     * @param integer $cantidad Cantidad de unidades
     * @param decimal $precio Precio total
     * @return Existencias Objeto Existencia
    */
    
    public function aumentar(Existencias $existencia, Articulos $articulo, Programas $programa, $cantidad, $precio)
    {        
        $cantidadActual = $existencia->getCantidad();
        $totalActual = $existencia->getTotal();
        
        $totalNuevo = $totalActual + round(($precio * $cantidad), 2);
        $cantidadNueva = $cantidadActual + $cantidad;
        
        
        $existencia->setCantidad($cantidadNueva);
        $existencia->setTotal($totalNuevo);
        
        return $existencia;
    }
    
    public function disminuir(Existencias $existencia, Articulos $articulo, Programas $programa, $cantidad, $precio)
    {
        $cantidadActual = $existencia->getCantidad();
        $totalActual = $existencia->getTotal();
        
        $totalNuevo = $totalActual - round(($precio * $cantidad), 2);
        
        $cantidadNueva = $cantidadActual - $cantidad;
        
        $existencia->setCantidad($cantidadNueva);
        $existencia->setTotal($totalNuevo);
        
        return $existencia;
    }
}
