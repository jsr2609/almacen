<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SalidaDetallesRepository")
 * @ORM\Table(
 *     name="SalidaDetalles")
 */
class SalidaDetalles
{
    /**
     * @ORM\Id
     * @ORM\Column(name="Id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
     /**
     * @ORM\ManyToOne(targetEntity="Salidas")
     * @ORM\JoinColumn(name="SalidaId", referencedColumnName="Id", nullable=false, onDelete="CASCADE")
    */
    private $salida;
    
     /**
     * @ORM\ManyToOne(targetEntity="Articulos")
     * @ORM\JoinColumn(name="ArticuloId", referencedColumnName="Id", nullable=false, onDelete="RESTRICT")
    */
    private $articulo;

    /**
     * @ORM\Column(name="Cantidad", type="integer", nullable=false)
     */
    private $cantidad;

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
    
    /**
     * @ORM\ManyToOne(targetEntity="EntradaDetalles")
     * @ORM\JoinColumn(name="EntradaDetalleId", referencedColumnName="Id", nullable=true, onDelete="RESTRICT")
     */
    private $entradaDetalle;
    
     public function __construct() 
    {
        $this->fechaCreacion = new \DateTime();
        $this->fechaActualizacion = new \DateTime();
    }
    

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
     * Set cantidad
     *
     * @param integer $cantidad
     * @return SalidaDetalles
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return SalidaDetalles
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
     * @return SalidaDetalles
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
     * @return SalidaDetalles
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
     * Set salida
     *
     * @param \AppBundle\Entity\Salidas $salida
     * @return SalidaDetalles
     */
    public function setSalida(\AppBundle\Entity\Salidas $salida)
    {
        $this->salida = $salida;

        return $this;
    }

    /**
     * Get salida
     *
     * @return \AppBundle\Entity\Salidas 
     */
    public function getSalida()
    {
        return $this->salida;
    }

    /**
     * Set articulo
     *
     * @param \AppBundle\Entity\Articulos $articulo
     * @return SalidaDetalles
     */
    public function setArticulo(\AppBundle\Entity\Articulos $articulo)
    {
        $this->articulo = $articulo;

        return $this;
    }

    /**
     * Get articulo
     *
     * @return \AppBundle\Entity\Articulos 
     */
    public function getArticulo()
    {
        return $this->articulo;
    }

    /**
     * Set entradaDetalle
     *
     * @param \AppBundle\Entity\EntradaDetalles $entradaDetalle
     * @return SalidaDetalles
     */
    public function setEntradaDetalle(\AppBundle\Entity\EntradaDetalles $entradaDetalle = null)
    {
        $this->entradaDetalle = $entradaDetalle;

        return $this;
    }

    /**
     * Get entradaDetalle
     *
     * @return \AppBundle\Entity\EntradaDetalles 
     */
    public function getEntradaDetalle()
    {
        return $this->entradaDetalle;
    }
}
