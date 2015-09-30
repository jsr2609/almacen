<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table()
 */
class VwSalidas
{
    /**
     * @ORM\Id
     * @ORM\Column(name="Id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(name="EjercicioId")
    */
    private $ejercicio;
    
    /**
     * @ORM\Column(name="ProgramaId")
    */
    private $programa;
    
    /**
     * @ORM\Column(name="DestinoId")
    */
    private $destino;

    /**
     * @ORM\Column(name="Folio", type="integer", length=2, nullable=false)
     */
    private $folio;

    /**
     * @ORM\Column(name="Fecha", type="date", nullable=false)
     */
    private $fecha;

    /**
     * @ORM\Column(name="TipoEntradaId", type="smallint", nullable=false)
     */
    private $tipoCompra;

    /**
     * @ORM\Column(name="NombreQuienRecibe", type="string", length=150, nullable=false)
     */
    private $nombreQuienRecibe;

    /**
     * @ORM\Column(name="AreaQueRecibe", type="string", length=150, nullable=false)
     */
    private $areaQueRecibe;

    /**
     * @ORM\Column(name="Observaciones", type="string", nullable=true)
     */
    private $observaciones;

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
     * Set ejercicio
     *
     * @param string $ejercicio
     * @return VwSalidas
     */
    public function setEjercicio($ejercicio)
    {
        $this->ejercicio = $ejercicio;

        return $this;
    }

    /**
     * Get ejercicio
     *
     * @return string 
     */
    public function getEjercicio()
    {
        return $this->ejercicio;
    }

    /**
     * Set programa
     *
     * @param string $programa
     * @return VwSalidas
     */
    public function setPrograma($programa)
    {
        $this->programa = $programa;

        return $this;
    }

    /**
     * Get programa
     *
     * @return string 
     */
    public function getPrograma()
    {
        return $this->programa;
    }

    /**
     * Set destino
     *
     * @param string $destino
     * @return VwSalidas
     */
    public function setDestino($destino)
    {
        $this->destino = $destino;

        return $this;
    }

    /**
     * Get destino
     *
     * @return string 
     */
    public function getDestino()
    {
        return $this->destino;
    }

    /**
     * Set folio
     *
     * @param integer $folio
     * @return VwSalidas
     */
    public function setFolio($folio)
    {
        $this->folio = $folio;

        return $this;
    }

    /**
     * Get folio
     *
     * @return integer 
     */
    public function getFolio()
    {
        return $this->folio;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return VwSalidas
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set tipoEntrada
     *
     * @param integer $tipoEntrada
     * @return VwSalidas
     */
    public function setTipoEntrada($tipoEntrada)
    {
        $this->tipoEntrada = $tipoEntrada;

        return $this;
    }

    /**
     * Get tipoEntrada
     *
     * @return integer 
     */
    public function getTipoEntrada()
    {
        return $this->tipoEntrada;
    }

    /**
     * Set nombreQuienRecibe
     *
     * @param string $nombreQuienRecibe
     * @return VwSalidas
     */
    public function setNombreQuienRecibe($nombreQuienRecibe)
    {
        $this->nombreQuienRecibe = $nombreQuienRecibe;

        return $this;
    }

    /**
     * Get nombreQuienRecibe
     *
     * @return string 
     */
    public function getNombreQuienRecibe()
    {
        return $this->nombreQuienRecibe;
    }

    /**
     * Set areaQueRecibe
     *
     * @param string $areaQueRecibe
     * @return VwSalidas
     */
    public function setAreaQueRecibe($areaQueRecibe)
    {
        $this->areaQueRecibe = $areaQueRecibe;

        return $this;
    }

    /**
     * Get areaQueRecibe
     *
     * @return string 
     */
    public function getAreaQueRecibe()
    {
        return $this->areaQueRecibe;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return VwSalidas
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return VwSalidas
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
     * @return VwSalidas
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
     * @return VwSalidas
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
}
