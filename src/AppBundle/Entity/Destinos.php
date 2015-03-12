<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Destinos")
 */
class Destinos
{
    /**
     * @ORM\Id
     * @ORM\Column(name="Id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(name="Clave", type="string", length=5, nullable=false, unique=true)
     */
    private $clave;
    
    /**
     * @ORM\Column(name="Nombre", type="string", length=150, nullable=false)
     */
    private $nombre;
    
    /**
     * @ORM\Column(name="Nombre1", type="string", length=150, nullable=true)
     */
    private $nombre1;
    
    /**
     * @ORM\Column(name="Nombre2", type="string", length=150, nullable=true)
     */
    private $nombre3;
}