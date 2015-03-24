<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Inventarios;

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
    /**
    * Aumenta la cantidad de existencias de un artículo
    * 
    * @param object $articulo Id del Artículo
    * @param object $progama Id del Programa
    * @param integer $cantidad Cantidad de unidades
    * @param decimal $precio Precio total
    */
    public function aumentar(Existencias $existencia, Articulos $articulo, Programas $programa, $cantidad, $precio)
    {        
        
        $cantidadActual = $existencia->getCantidad();
        $precioPromedioActual = $existencia->getPrecio();
        $totalActual = $cantidadActual * $precioPromedioActual;
        
        $cantidadNueva = $cantidadActual + $cantidad;
        $totalNuevo = $totalActual + ($precio * $cantidad);
        $precioPromedioNuevo = $totalNuevo / $cantidadNueva;
        
        $existencia->setCantidad($cantidadNueva);
        $existencia->setPrecio($precioPromedioNuevo);
        
        $em = $this->base->getManager();
        $em->persist($existencia);
    }
}
