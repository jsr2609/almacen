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

use AppBundle\Entity\Programas;
use SSA\UtilidadesBundle\Manager\BaseManager;


class ProgramasManager 
{
    private $base; 
    private $repository = "AppBundle:Programas";
    
        
    public function __construct(BaseManager $base)
    {
        $this->base = $base;
    }
    
    public function comprobarExistencia($valor, $datos, $campo = 'clave')
    {
        $repository = $this->getRepository();
        $programa = $repository->findOneBy(array(
            $campo => $valor,
        ));
        
        if(!$programa) {
            $em = $this->base->getManager();
            $programa = new Programas();
            $programa->setClave($datos['clave']);
            $programa->setNombre($datos['nombre']);
            $em->persist($programa);
            $em->flush();
        }
        
        return $programa;
    }
    
    /**
     * 
     * @param type $repository
     * @return ProveedoresRepository
     */
    private function getRepository($repository =  null)
    {
        if($repository === null) {
            $repository = $this->repository;
        }
        
        return $this->base->getRepository($repository);
    }
}