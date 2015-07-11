<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Almacenes")
 */
class Almacenes
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
     * @ORM\Column(name="Domicilio", type="string", length=255, nullable=false)
     */
    private $domicilio;
    
    /**
     * @ORM\Column(name="Telefonos", type="string", length=50, nullable=true)
     */
    private $telefonos;

    /**
     * @ORM\Column(name="NombreResponsableAlmacen", type="string", length=150, nullable=false)
     */
    private $nombreResponsableAlmacen;

    /**
     * @ORM\Column(name="CargoResponsableAlmacen", type="string", length=150, nullable=false)
     */
    private $cargoResponsableAlmacen;

    /**
     * @ORM\Column(name="NombreRecursosMateriales", type="string", length=150, nullable=false)
     */
    private $nombreRecursosMateriales;

    /**
     * @ORM\Column(name="CargoRecursosMateriales", type="string", length=150, nullable=false)
     */
    private $cargoRecursosMateriales;

    /**
     * @ORM\Column(name="NombreJefeServicios", type="string", length=150, nullable=false)
     */
    private $nombreJefeServicios;

    /**
     * @ORM\Column(name="Lugar", type="string", length=150, nullable=false)
     */
    private $lugar;

    /**
     * @ORM\Column(name="FechaCreacion", type="datetime", nullable=false)
     */
    private $fechaCreacion;

    /**
     * @ORM\Column(name="FechaActualizacion", type="datetime", nullable=false)
     */
    private $fechaActualizacion;
    
    /**
     * @ORM\Column(name="Activo", type="boolean", nullable=false)
     */
    private $activo = true;
    
    public function __toString() {
        return $this->nombre;
    }
    
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
     * Set nombre
     *
     * @param string $nombre
     * @return Almacenes
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
     * Set domicilio
     *
     * @param string $domicilio
     * @return Almacenes
     */
    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;

        return $this;
    }

    /**
     * Get domicilio
     *
     * @return string 
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }

    /**
     * Set nombreResponsableAlmacen
     *
     * @param string $nombreResponsableAlmacen
     * @return Almacenes
     */
    public function setNombreResponsableAlmacen($nombreResponsableAlmacen)
    {
        $this->nombreResponsableAlmacen = $nombreResponsableAlmacen;

        return $this;
    }

    /**
     * Get nombreResponsableAlmacen
     *
     * @return string 
     */
    public function getNombreResponsableAlmacen()
    {
        return $this->nombreResponsableAlmacen;
    }

    /**
     * Set cargoResponsableAlmacen
     *
     * @param string $cargoResponsableAlmacen
     * @return Almacenes
     */
    public function setCargoResponsableAlmacen($cargoResponsableAlmacen)
    {
        $this->cargoResponsableAlmacen = $cargoResponsableAlmacen;

        return $this;
    }

    /**
     * Get cargoResponsableAlmacen
     *
     * @return string 
     */
    public function getCargoResponsableAlmacen()
    {
        return $this->cargoResponsableAlmacen;
    }

    /**
     * Set nombreRecursosMateriales
     *
     * @param string $nombreRecursosMateriales
     * @return Almacenes
     */
    public function setNombreRecursosMateriales($nombreRecursosMateriales)
    {
        $this->nombreRecursosMateriales = $nombreRecursosMateriales;

        return $this;
    }

    /**
     * Get nombreRecursosMateriales
     *
     * @return string 
     */
    public function getNombreRecursosMateriales()
    {
        return $this->nombreRecursosMateriales;
    }

    /**
     * Set cargoRecursosMateriales
     *
     * @param string $cargoRecursosMateriales
     * @return Almacenes
     */
    public function setCargoRecursosMateriales($cargoRecursosMateriales)
    {
        $this->cargoRecursosMateriales = $cargoRecursosMateriales;

        return $this;
    }

    /**
     * Get cargoRecursosMateriales
     *
     * @return string 
     */
    public function getCargoRecursosMateriales()
    {
        return $this->cargoRecursosMateriales;
    }

    /**
     * Set nombreJefeServicios
     *
     * @param string $nombreJefeServicios
     * @return Almacenes
     */
    public function setNombreJefeServicios($nombreJefeServicios)
    {
        $this->nombreJefeServicios = $nombreJefeServicios;

        return $this;
    }

    /**
     * Get nombreJefeServicios
     *
     * @return string 
     */
    public function getNombreJefeServicios()
    {
        return $this->nombreJefeServicios;
    }

    /**
     * Set lugar
     *
     * @param string $lugar
     * @return Almacenes
     */
    public function setLugar($lugar)
    {
        $this->lugar = $lugar;

        return $this;
    }

    /**
     * Get lugar
     *
     * @return string 
     */
    public function getLugar()
    {
        return $this->lugar;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return Almacenes
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
     * @return Almacenes
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
     * Set activo
     *
     * @param boolean $activo
     * @return Almacenes
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
     * Set telefonos
     *
     * @param string $telefonos
     * @return Almacenes
     */
    public function setTelefonos($telefonos)
    {
        $this->telefonos = $telefonos;

        return $this;
    }

    /**
     * Get telefonos
     *
     * @return string 
     */
    public function getTelefonos()
    {
        return $this->telefonos;
    }
}
