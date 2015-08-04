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
use AppBundle\Entity\Existencias;
use AppBundle\Entity\Ejercicios;
use AppBundle\Inventarios\PEPS;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExistenciasManager 
{
    private $base;
    private $repository = 'AppBundle:Existencias';
        
    public function __construct(BaseManager $base)
    {
        $this->base = $base;
    }
    
    public function buscar($articulo, $programa, $devolverNulo = true)
    {
        $existenciasRepository = $this->getRepository();
        $existencia = $existenciasRepository->findOneBy(array(
            'programa' => $programa,
            'articulo' => $articulo,
        ));
        if(!$existencia && !$devolverNulo){
            $msg = 'No se encontró un registro en la tabla Existencia con los valores: '
                    . '{ articulo: '.$articulo->getId().', programa: '.$programa->getId().' }';
            throw $this->base->createNotFoundException($msg);
        }
        
        return $existencia;
    }
    
    /**
     * Crea un registro en la tabla existencias
     * 
     * @param type $articulo
     * @param type $programa
     * @return Existencias
     */
    public function crear($articulo, $programa)
    {
        $entity = new Existencias();
        $entity->setArticulo($articulo);
        $entity->setPrograma($programa);
        $entity->setCantidad(0);
        $entity->setPrecio(0);
        $entity->setTotal(0);
        
        $em = $this->base->getManager();
        $em->persist($entity);
        $em->flush($entity);
        
        return $entity;
    }
    
   /**
    * Aumenta la cantidad de existencias de un artículo
    * 
    * @param object $articulo Id del Artículo
    * @param object $programa Id del Programa
    * @param integer $cantidad Cantidad de unidades
    * @param decimal $precio Precio total
    */
    public function aumentar($articulo, $programa, $cantidad, $precio, $ejercicio, $aplicaIVA)
    {
        $tipoInventario = $ejercicio['tipoInventario'];
        $iva = $ejercicio['iva'];
        if($aplicaIVA) {
            $precio = round($precio + ($precio * ($iva/100)), 2);
        }
        $existencia = $this->buscar($articulo, $programa);
        
        if(!$existencia) {
            $existencia = $this->crear($articulo, $programa);
        }
        
        switch($tipoInventario) {
            case 1:
                $inventario = new PEPS();
                $existencia = $inventario->aumentar($existencia, $articulo, $programa, $cantidad, $precio);
                break;
            case 2:
                break;
            default:
                throw new \LogicException("Error al aumentar las existencias, no se ha definido el tipo de inventario: ".$tipoInventario);
        }
        
        $this->base->getManager()->persist($existencia);
    }
    
    /**
     * 
     * @param Articulos $articulo
     * @param Programas $programa
     * @param type $cantidad
     * @param type $precio
     */
    public function disminuir(Articulos $articulo, Programas $programa, $cantidad, $precio, $ejercicio, $aplicaIva) 
    {
        
        $tipoInventario = $ejercicio['tipoInventario'];
        $iva = $ejercicio['iva'];
        if($aplicaIva) {
            $precio = round(($precio + ($precio * ($iva / 100))), 2);
        }
        
        $existencia = $this->buscar($articulo, $programa, false);
        
        switch($tipoInventario) {
            case 1:
                $inventario = new PEPS();
                $existencia = $inventario->disminuir($existencia, $articulo, $programa, $cantidad, $precio);
                break;
            case 2:
                break;
            default:
                throw new \LogicException("Error al aumentar las existencias, no se ha definido el tipo de inventario: ".$tipoInventario);
        }
        
        $this->base->getManager()->persist($existencia);
    }
    
    /**
     * 
     * @return Ejercicios
     */
    public function buscarEjercicio() 
    {
        $almacenDatos = $this->base->getSession()->get('almacen');
        $ejercicio = $this->base->getRepository("AppBundle:Ejercicios")->findOneBy(array(
            'almacen' => $almacenDatos['id'],
            'periodo' => $almacenDatos['ejercicio']['periodo'],
        ));
        
        return $ejercicio;
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