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

class ExistenciasManager 
{
    private $repository = "AppBundle:Existencias";
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