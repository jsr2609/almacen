<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Proveedores")
 */
class Proveedores
{
    /**
     * @ORM\Id
     * @ORM\Column(name="Id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="Nombre", type="string", length=150, nullable=false)
     */
    private $nombre;

    /**
     * @ORM\Column(name="FechaCreacion", type="datetime", nullable=false)
     */
    private $fechaCreacion;

    /**
     * @ORM\Column(name="FechaActualizacion", type="datetime", nullable=false)
     */
    private $fechaActualizacion;
    
    
     public function __construct() 
    {
        $this->fechaCreacion = new \DateTime();
        $this->fechaActualizacion = new \DateTime();
    }
    
}