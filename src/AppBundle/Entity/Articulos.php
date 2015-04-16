<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Articulos")
 */
class Articulos
{
    /**
     * @ORM\Id
     * @ORM\Column(name="Id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Partidas")
     * @ORM\JoinColumn(name="PartidaId", referencedColumnName="Id", nullable=false, onDelete="RESTRICT")
    */
    private $partida;
    
    /**
     * @ORM\Column(name="partidaClave", type="string", length=6, nullable=true)
     */
    private $partidaClave;

    /**
     * @ORM\Column(name="Clave", type="string", length=15, nullable=false)
     */
    private $clave;

    /**
     * @ORM\Column(name="Nombre", type="string", length=45, nullable=false)
     */
    private $nombre;

    /**
     * @ORM\Column(name="PresentacionId", type="integer", length=2, nullable=false)
     */
    private $presentacion;

    /**
     * @ORM\Column(name="Cantidad", type="integer", length=2, nullable=true)
     */
    private $cantidad;

    /**
     * @ORM\Column(name="UnidadMedidaPresentacion", type="string", length=45, nullable=true)
     */
    private $unidadMedidaPresentacion;
    
    /**
     * @ORM\Column(name="PresentacionNombre", type="string", length=50, nullable=true)
     */
    private $presentacionNombre;

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
     * @return Articulos
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
     * @return Articulos
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
     * Set presentacion
     *
     * @param integer $presentacion
     * @return Articulos
     */
    public function setPresentacion($presentacion)
    {
        $this->presentacion = $presentacion;

        return $this;
    }

    /**
     * Get presentacion
     *
     * @return integer 
     */
    public function getPresentacion()
    {
        return $this->presentacion;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     * @return Articulos
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
     * Set unidadMedidaPresentacion
     *
     * @param string $unidadMedidaPresentacion
     * @return Articulos
     */
    public function setUnidadMedidaPresentacion($unidadMedidaPresentacion)
    {
        $this->unidadMedidaPresentacion = $unidadMedidaPresentacion;

        return $this;
    }

    /**
     * Get unidadMedidaPresentacion
     *
     * @return string 
     */
    public function getUnidadMedidaPresentacion()
    {
        return $this->unidadMedidaPresentacion;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Articulos
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
     * @return Articulos
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
     * @return Articulos
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
     * Set partida
     *
     * @param \AppBundle\Entity\Partidas $partida
     * @return Articulos
     */
    public function setPartida(\AppBundle\Entity\Partidas $partida)
    {
        $this->partida = $partida;

        return $this;
    }

    /**
     * Get partida
     *
     * @return \AppBundle\Entity\Partidas 
     */
    public function getPartida()
    {
        return $this->partida;
    }
}
