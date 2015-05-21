<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SalidasRepository")
 * @ORM\Table(
 *     name="Salidas")
 */
class Salidas
{
    
    public static $salidasTipos = array(
        1 => 'Directa',
        2 => 'Donación',
        3 => 'Licitación',
        4 => 'Otra',
    );
    
    /**
     * @ORM\Id
     * @ORM\Column(name="Id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Ejercicios")
     * @ORM\JoinColumn(name="EjercicioId", referencedColumnName="Id", nullable=false, onDelete="RESTRICT")
    */
    private $ejercicio;
    
    /**
     * @ORM\ManyToOne(targetEntity="Programas")
     * @ORM\JoinColumn(name="ProgramaId", referencedColumnName="Id", nullable=false, onDelete="RESTRICT")
    */
    private $programa;
    
    /**
     * @ORM\ManyToOne(targetEntity="Destinos")
     * @ORM\JoinColumn(name="DestinoId", referencedColumnName="Id", nullable=false, onDelete="RESTRICT")
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
    private $tipoEntrada;

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
     * Set id
     *
     * @param integer $id
     * @return Salidas
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Set folio
     *
     * @param integer $folio
     * @return Salidas
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
     * @return Salidas
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
     * @return Salidas
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
     * @return Salidas
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
     * @return Salidas
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
     * @return Salidas
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
     * @return Salidas
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
     * @return Salidas
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
     * @return Salidas
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
     * Set ejercicio
     *
     * @param \AppBundle\Entity\Ejercicios $ejercicio
     * @return Salidas
     */
    public function setEjercicio(\AppBundle\Entity\Ejercicios $ejercicio)
    {
        $this->ejercicio = $ejercicio;

        return $this;
    }

    /**
     * Get ejercicio
     *
     * @return \AppBundle\Entity\Ejercicios 
     */
    public function getEjercicio()
    {
        return $this->ejercicio;
    }

    /**
     * Set programa
     *
     * @param \AppBundle\Entity\Programas $programa
     * @return Salidas
     */
    public function setPrograma(\AppBundle\Entity\Programas $programa)
    {
        $this->programa = $programa;

        return $this;
    }

    /**
     * Get programa
     *
     * @return \AppBundle\Entity\Programas 
     */
    public function getPrograma()
    {
        return $this->programa;
    }

    /**
     * Set destino
     *
     * @param \AppBundle\Entity\Destinos $destino
     * @return Salidas
     */
    public function setDestino(\AppBundle\Entity\Destinos $destino)
    {
        $this->destino = $destino;

        return $this;
    }

    /**
     * Get destino
     *
     * @return \AppBundle\Entity\Destinos 
     */
    public function getDestino()
    {
        return $this->destino;
    }
}
