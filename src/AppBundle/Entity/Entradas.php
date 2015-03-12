<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="Entradas")
 */
class Entradas
{
    /**
     * @ORM\Id
     * @ORM\Column(name="Id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Proveedores")
     * @ORM\JoinColumn(name="ProveedorId", referencedColumnName="Id", nullable=false, onDelete="RESTRICT")
    */
    private $proveedor;
    
    /**
     * @ORM\ManyToOne(targetEntity="Programas")
     * @ORM\JoinColumn(name="ProgramaId", referencedColumnName="Id", nullable=false, onDelete="RESTRICT")
    */
    private $programa;
    
    /**
     * @ORM\ManyToOne(targetEntity="Ejercicios")
     * @ORM\JoinColumn(name="EjercicioId", referencedColumnName="Id", nullable=false, onDelete="RESTRICT")
    */
    private $ejercicio;
    
    
    /**
     * @ORM\Column(name="Folio", type="integer", length=2, nullable=false)
     */
    private $folio;

    /**
     * @ORM\Column(name="Fecha", type="date", nullable=false)
     */
    private $fecha;

    
    /**
     * @ORM\ManyToOne(targetEntity="EntradaTipos", cascade={})
     * @ORM\JoinColumn(name="TipoEntradaId", referencedColumnName="Id", nullable=false, onDelete="RESTRICT")
     */
    private $tipoEntrada;

    /**
     * @ORM\Column(name="Observaciones", type="string", nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\Column(name="PedidoNumero", type="string", length=10, nullable=true)
     */
    private $pedidoNumero;

    /**
     * @ORM\Column(name="PedidoTipoId", type="integer", length=1, nullable=true)
     */
    private $pedidoTipo;

    /**
     * @ORM\Column(name="NumeroFactura", type="string", length=10, nullable=true)
     */
    private $numeroFactura;

    /**
     * @ORM\Column(name="FechaFactura", type="date", nullable=true)
     */
    private $fechaFactura;

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
     * Set folio
     *
     * @param integer $folio
     * @return Entradas
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
     * @return Entradas
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
     * @return Entradas
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
     * Set observaciones
     *
     * @param string $observaciones
     * @return Entradas
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
     * Set pedidoNumero
     *
     * @param string $pedidoNumero
     * @return Entradas
     */
    public function setPedidoNumero($pedidoNumero)
    {
        $this->pedidoNumero = $pedidoNumero;

        return $this;
    }

    /**
     * Get pedidoNumero
     *
     * @return string 
     */
    public function getPedidoNumero()
    {
        return $this->pedidoNumero;
    }

    /**
     * Set pedidoTipo
     *
     * @param integer $pedidoTipo
     * @return Entradas
     */
    public function setPedidoTipo($pedidoTipo)
    {
        $this->pedidoTipo = $pedidoTipo;

        return $this;
    }

    /**
     * Get pedidoTipo
     *
     * @return integer 
     */
    public function getPedidoTipo()
    {
        return $this->pedidoTipo;
    }

    /**
     * Set numeroFactura
     *
     * @param string $numeroFactura
     * @return Entradas
     */
    public function setNumeroFactura($numeroFactura)
    {
        $this->numeroFactura = $numeroFactura;

        return $this;
    }

    /**
     * Get numeroFactura
     *
     * @return string 
     */
    public function getNumeroFactura()
    {
        return $this->numeroFactura;
    }

    /**
     * Set fechaFactura
     *
     * @param \DateTime $fechaFactura
     * @return Entradas
     */
    public function setFechaFactura($fechaFactura)
    {
        $this->fechaFactura = $fechaFactura;

        return $this;
    }

    /**
     * Get fechaFactura
     *
     * @return \DateTime 
     */
    public function getFechaFactura()
    {
        return $this->fechaFactura;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return Entradas
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
     * @return Entradas
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
     * Set proveedor
     *
     * @param \AppBundle\Entity\Proveedores $proveedor
     * @return Entradas
     */
    public function setProveedor(\AppBundle\Entity\Proveedores $proveedor)
    {
        $this->proveedor = $proveedor;

        return $this;
    }

    /**
     * Get proveedor
     *
     * @return \AppBundle\Entity\Proveedores 
     */
    public function getProveedor()
    {
        return $this->proveedor;
    }

    /**
     * Set programa
     *
     * @param \AppBundle\Entity\Programas $programa
     * @return Entradas
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
     * Set ejercicio
     *
     * @param \AppBundle\Entity\Ejercicios $ejercicio
     * @return Entradas
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
}
