<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * ORM\Entity(repositoryClass="AppBundle\Repository\DestinosRepository")
 * ORM\Table(name="Destinos")
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

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set clave
     *
     * @param string $clave
     * @return Destinos
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get clave
     *
     * @return string 
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Destinos
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set nombre1
     *
     * @param string $nombre1
     * @return Destinos
     */
    public function setNombre1($nombre1)
    {
        $this->nombre1 = $nombre1;

        return $this;
    }

    /**
     * Get nombre1
     *
     * @return string 
     */
    public function getNombre1()
    {
        return $this->nombre1;
    }

    /**
     * Set nombre3
     *
     * @param string $nombre3
     * @return Destinos
     */
    public function setNombre3($nombre3)
    {
        $this->nombre3 = $nombre3;

        return $this;
    }

    /**
     * Get nombre3
     *
     * @return string 
     */
    public function getNombre3()
    {
        return $this->nombre3;
    }
}
