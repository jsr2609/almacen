<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EntradasRepository")
 * @ORM\Table(
 *     name="Entradas")
 */
class Entradas
{
    public static $entradaTipos = array(
        1 => 'Directa',
        2 => 'Donación',
        3 => 'Licitación',
        4 => 'Otra',
    );
    
    public static $pedidoTipos = array(
        1 => 'Orden',
        2 => 'Pedido',
        3 => 'Propuesta',
        4 => 'Otro',
    );
    
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
     * @ORM\Column(name="TipoEntradaId", type="smallint", nullable=false)
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
     * @ORM\Column(name="FacturaNumero", type="string", length=10, nullable=true)
     */
    private $facturaNumero;

    /**
     * @ORM\Column(name="FacturaFecha", type="date", nullable=true)
     */
    private $facturaFecha;

    /**
     * @ORM\Column(name="FechaCreacion", type="datetime", nullable=false)
     */
    private $fechaCreacion;

    /**
     * @ORM\Column(name="FechaActualizacion", type="datetime", nullable=false)
     */
    private $fechaActualizacion;
    
    /**
     * @ORM\ManyToOne(targetEntity="SSA\SeguridadBundle\Entity\Usuarios", cascade={})
     * @ORM\JoinColumn(name="UsuarioId", referencedColumnName="Id", nullable=false, onDelete="RESTRICT")
     */
    private $usuario;
    
    /**
     * @ORM\Column(name="Activa", type="boolean", nullable=false)
     */
    private $activa = true;
    
    /**
     * @ORM\Column(name="Validada", type="boolean", nullable=false)
     */
    private $validada = false;
    
     public function __construct() 
    {
        $this->fechaCreacion = new \DateTime();
        $this->fechaActualizacion = new \DateTime();
    }
    
    public function getTipoEntradaNombre()
    {
        return self::$entradaTipos[$this->tipoEntrada];
    }
    
    public function getPedidoTipoNombre()
    {
        $nombre = $this->pedidoTipo == null ? "" : self::$pedidoTipos[$this->pedidoTipo];
        return $nombre;
    }
    
    //Funciones autogeneradas

    

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
     * Set facturaNumero
     *
     * @param string $facturaNumero
     * @return Entradas
     */
    public function setFacturaNumero($facturaNumero)
    {
        $this->facturaNumero = $facturaNumero;

        return $this;
    }

    /**
     * Get facturaNumero
     *
     * @return string 
     */
    public function getFacturaNumero()
    {
        return $this->facturaNumero;
    }

    /**
     * Set facturaFecha
     *
     * @param \DateTime $facturaFecha
     * @return Entradas
     */
    public function setFacturaFecha($facturaFecha)
    {
        $this->facturaFecha = $facturaFecha;

        return $this;
    }

    /**
     * Get facturaFecha
     *
     * @return \DateTime 
     */
    public function getFacturaFecha()
    {
        return $this->facturaFecha;
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
     * Set activa
     *
     * @param boolean $activa
     * @return Entradas
     */
    public function setActiva($activa)
    {
        $this->activa = $activa;

        return $this;
    }

    /**
     * Get activa
     *
     * @return boolean 
     */
    public function getActiva()
    {
        return $this->activa;
    }

    /**
     * Set validada
     *
     * @param boolean $validada
     * @return Entradas
     */
    public function setValidada($validada)
    {
        $this->validada = $validada;

        return $this;
    }

    /**
     * Get validada
     *
     * @return boolean 
     */
    public function getValidada()
    {
        return $this->validada;
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

    /**
     * Set usuario
     *
     * @param \SSA\SeguridadBundle\Entity\Usuarios $usuario
     * @return Entradas
     */
    public function setUsuario(\SSA\SeguridadBundle\Entity\Usuarios $usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \SSA\SeguridadBundle\Entity\Usuarios 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
