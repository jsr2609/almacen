<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="Ejercicios"
 * )
 */
class Ejercicios
{
    /**
     * @ORM\Id
     * @ORM\Column(name="Id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Almacenes")
     * @ORM\JoinColumn(name="AlmacenId", referencedColumnName="Id", nullable=false, onDelete="RESTRICT")
    */
    private $almacen;
    
    /**
     * @ORM\Column(name="Periodo", type="integer", nullable=false)
     */
    private $periodo;

    /**
     * @ORM\Column(name="NumeroEntradas", type="integer", nullable=false)
     */
    private $numeroEntradas;

    /**
     * @ORM\Column(name="NumeroSalidas", type="integer", nullable=false)
     */
    private $numeroSalidas;

    /**
     * @ORM\Column(name="IVA", type="smallint", nullable=false)
     */
    private $iva;

    /**
     * @ORM\Column(name="Activo", type="boolean", nullable=false)
     */
    private $activo = true;

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
    /**
     * Inicio Funciones autogeneradas
     */
    
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
     * Set numeroEntradas
     *
     * @param integer $numeroEntradas
     * @return Ejercicios
     */
    public function setNumeroEntradas($numeroEntradas)
    {
        $this->numeroEntradas = $numeroEntradas;

        return $this;
    }

    /**
     * Get numeroEntradas
     *
     * @return integer 
     */
    public function getNumeroEntradas()
    {
        return $this->numeroEntradas;
    }

    /**
     * Set numeroSalidas
     *
     * @param integer $numeroSalidas
     * @return Ejercicios
     */
    public function setNumeroSalidas($numeroSalidas)
    {
        $this->numeroSalidas = $numeroSalidas;

        return $this;
    }

    /**
     * Get numeroSalidas
     *
     * @return integer 
     */
    public function getNumeroSalidas()
    {
        return $this->numeroSalidas;
    }

    /**
     * Set iva
     *
     * @param integer $iva
     * @return Ejercicios
     */
    public function setIva($iva)
    {
        $this->iva = $iva;

        return $this;
    }

    /**
     * Get iva
     *
     * @return integer 
     */
    public function getIva()
    {
        return $this->iva;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Ejercicios
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean 
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return Ejercicios
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime 
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set fechaActualizacion
     *
     * @param \DateTime $fechaActualizacion
     * @return Ejercicios
     */
    public function setFechaActualizacion($fechaActualizacion)
    {
        $this->fechaActualizacion = $fechaActualizacion;

        return $this;
    }

    /**
     * Get fechaActualizacion
     *
     * @return \DateTime 
     */
    public function getFechaActualizacion()
    {
        return $this->fechaActualizacion;
    }

    /**
     * Set almacen
     *
     * @param \AppBundle\Entity\Almacenes $almacen
     * @return Ejercicios
     */
    public function setAlmacen(\AppBundle\Entity\Almacenes $almacen)
    {
        $this->almacen = $almacen;

        return $this;
    }

    /**
     * Get almacen
     *
     * @return \AppBundle\Entity\Almacenes 
     */
    public function getAlmacen()
    {
        return $this->almacen;
    }

    /**
     * Set periodo
     *
     * @param integer $periodo
     * @return Ejercicios
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;

        return $this;
    }

    /**
     * Get periodo
     *
     * @return integer 
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }
}
