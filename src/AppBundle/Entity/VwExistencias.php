<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VwExistencias
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class VwExistencias
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="ProgramaId", type="integer")
     */
    private $programaId;

    /**
     * @var integer
     *
     * @ORM\Column(name="EntradaDetalleId", type="integer")
     */
    private $entradaDetalleId;

    /**
     * @ORM\Column(name="Cantidad", type="integer")
     */
    private $cantidad;
    
    /**
     * @ORM\Column(name="Existencia", type="integer")
     */
    private $existencia;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="TipoEntrada", type="integer")
     */
    private $tipoEntrada;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="Clave", type="string", length=15)
     */
    private $clave;
    
    /**
     * @var string
     *
     * @ORM\Column(name="Nombre", type="text")
     */
    private $nombre;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="Partida", type="integer")
     */
    private $partidaId;
    
    /**
     * @var string
     *
     * @ORM\Column(name="PartidaClave", type="string", length=6)
     */
    private $partidaClave;
    
    /**
     * @var string
     *
     * @ORM\Column(name="PartidaNombre", type="string", length=150)
     */
    private $partidaNombre;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="PresentacionId", type="integer")
     */
    private $presentacionId;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="PresentacionNombre", type="string", length=50)
     */
    private $presentacionNombre;
    
     /**
     * @var boolean
     *
     * @ORM\Column(name="Activo", type="boolean")
     */
    private $activo;


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
     * Set programaId
     *
     * @param integer $programaId
     * @return VwExistencias
     */
    public function setProgramaId($programaId)
    {
        $this->programaId = $programaId;

        return $this;
    }

    /**
     * Get programaId
     *
     * @return integer 
     */
    public function getProgramaId()
    {
        return $this->programaId;
    }

    /**
     * Set entradaDetalleId
     *
     * @param integer $entradaDetalleId
     * @return VwExistencias
     */
    public function setEntradaDetalleId($entradaDetalleId)
    {
        $this->entradaDetalleId = $entradaDetalleId;

        return $this;
    }

    /**
     * Get entradaDetalleId
     *
     * @return integer 
     */
    public function getEntradaDetalleId()
    {
        return $this->entradaDetalleId;
    }

    /**
     * Set existencia
     *
     * @param integer $existencia
     * @return VwExistencias
     */
    public function setExistencia($existencia)
    {
        $this->existencia = $existencia;

        return $this;
    }

    /**
     * Get existencia
     *
     * @return integer 
     */
    public function getExistencia()
    {
        return $this->existencia;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     * @return VwExistencias
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
     * Set clave
     *
     * @param string $clave
     * @return VwExistencias
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
     * @return VwExistencias
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
     * Set partidaId
     *
     * @param integer $partidaId
     * @return VwExistencias
     */
    public function setPartidaId($partidaId)
    {
        $this->partidaId = $partidaId;

        return $this;
    }

    /**
     * Get partidaId
     *
     * @return integer 
     */
    public function getPartidaId()
    {
        return $this->partidaId;
    }

    /**
     * Set partidaClave
     *
     * @param string $partidaClave
     * @return VwExistencias
     */
    public function setPartidaClave($partidaClave)
    {
        $this->partidaClave = $partidaClave;

        return $this;
    }

    /**
     * Get partidaClave
     *
     * @return string 
     */
    public function getPartidaClave()
    {
        return $this->partidaClave;
    }

    /**
     * Set partidaNombre
     *
     * @param string $partidaNombre
     * @return VwExistencias
     */
    public function setPartidaNombre($partidaNombre)
    {
        $this->partidaNombre = $partidaNombre;

        return $this;
    }

    /**
     * Get partidaNombre
     *
     * @return string 
     */
    public function getPartidaNombre()
    {
        return $this->partidaNombre;
    }

    /**
     * Set presentacionId
     *
     * @param integer $presentacionId
     * @return VwExistencias
     */
    public function setPresentacionId($presentacionId)
    {
        $this->presentacionId = $presentacionId;

        return $this;
    }

    /**
     * Get presentacionId
     *
     * @return integer 
     */
    public function getPresentacionId()
    {
        return $this->presentacionId;
    }

    /**
     * Set tipoEntrada
     *
     * @param integer $tipoEntrada
     * @return VwExistencias
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
     * Set presentacionNombre
     *
     * @param string $presentacionNombre
     * @return VwExistencias
     */
    public function setPresentacionNombre($presentacionNombre)
    {
        $this->presentacionNombre = $presentacionNombre;

        return $this;
    }

    /**
     * Get presentacionNombre
     *
     * @return string 
     */
    public function getPresentacionNombre()
    {
        return $this->presentacionNombre;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return VwExistencias
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
}
