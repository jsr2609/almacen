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

namespace SSA\SeguridadBundle\Manager;

use Doctrine\ORM\EntityManager;
use SSA\UtilidadesBundle\Manager\BaseManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use SSA\SeguridadBundle\Entity\Usuarios;
use SSA\SeguridadBundle\Repository\UsuariosRepository;


class UsuariosManager 
{
    private $base;
    private $encoderFactory;
    private $repositorio = "SSASeguridadBundle:Usuarios";
    
    public function __construct(BaseManager $base, EncoderFactory $encoderFactory)
    {
        $this->base = $base;
        $this->encoderFactory = $encoderFactory;
    }
    
    public function generarPassword(Usuarios $usuario)
    {
        $encoder = $this->encoderFactory->getEncoder($usuario);
        $password = $encoder->encodePassword($usuario->getPassword(), $usuario->getSalt());
        
        return $password;
    }
    
    public function actualizarPassword(Usuarios $usuario)
    {
        $repositorio = $this->recuperarRepositorio();
        if(!$usuario->getPassword()){
            $password = $repositorio->recuperarPassword($usuario->getId());
        } else {
            $password = $this->generarPassword($usuario);
        }
        
        return $password;
    }
    
    /**
     * 
     * @return UsuariosRepository
     */
    public function recuperarRepositorio()
    {
    return $this->base->getManager()->getRepository($this->repositorio);
    }
    
}