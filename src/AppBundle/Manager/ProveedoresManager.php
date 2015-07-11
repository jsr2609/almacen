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

use AppBundle\Entity\Proveedores;
use SSA\UtilidadesBundle\Manager\BaseManager;


class ProveedoresManager 
{
    private $base; 
    private $repository = "AppBundle:Proveedores";
    
        
    public function __construct(BaseManager $base)
    {
        $this->base = $base;
    }
    
    public function comprobarExistencia($valor, $datos, $campo = 'rfc')
    {
        $repository = $this->getRepository();
        $proveedor = $repository->findOneBy(array(
            $campo => $valor,
        ));
        
        if(!$proveedor) {
            $em = $this->base->getManager();
            $proveedor = new Proveedores();
            $proveedor->setRfc($datos['rfc']);
            $proveedor->setNombre($datos['nombre']);
            $em->persist($proveedor);
            $em->flush();
        }
        
        return $proveedor;
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