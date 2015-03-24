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
use AppBundle\Entity\Ejercicios;
use AppBundle\Inventarios\PEPS;

class ExistenciasManager 
{
    private $base;
        
    public function __construct(BaseManager $base)
    {
        $this->base = $base;
    }
    
    public function buscar(Articulos $articulo, Programas $programa)
    {
        $existenciasRepository = $this->getRepository();
        $existencia = $existenciasRepository->findOneBy(array(
            'programa' => $programa->getId(),
            'articulo' => $articulo->getId(),
        ));
        
        if(!$existencia) {
            $existencia = $this->crear($articulo, $programa);
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
    public function crear(Articulos $articulo, Programas $programa)
    {
        $entity = new Existencias();
        $entity->setArticulo($articulo);
        $entity->setPrograma($programa);
        $entity->setCantidad(0);
        $entity->setPrecio(0);
        
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
    public function aumentar(Articulos $articulo, Programas $programa, $cantidad, $precio)
    {
        $ejercicio = $this->buscarEjercicio();
        $tipoInventario = $ejercicio->getTipoInventario();
        $existencia = $this->buscar($articulo, $programa);
        
        switch($tipoInventario) {
            case 1:
                $inventario = new PEPS();
                $inventario->aumentar($existencia, $articulo, $programa, $cantidad, $precio);
                break;
            case 2:
                break;
            default:
                throw new \LogicException("Error al aumentar las existencias, no se ha definido el tipo de inventario: ".$tipoInventario);
        }
        
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