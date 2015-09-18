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
    public static $pedidoTiposCompra = array(
        1 => 'DIRECTA',
        2 => "LICITACION PUBLICA NACIONAL (PALACIO)",
        3 => "(PALACIO) LICITACION PUBLICA NACIONAL",
        4 => "LICITACION PUBLICA NACIONAL",
        5 => "INVITACION FUNDADA EN ANTECEDENTES Y MERITOS",
        6 => "DIRECTA (PALACIO)",
        7 => "(PALACIO) LIC. PUB. INT. BAJO LA COBERT. DE TRAT.",
        8 => "LICITACION PUBLICA INTERNACIONAL (PALACIO)",
        9 => "INVITACION A CUANDO MENOS TRES PERSONAS",
        10 => "(PALACIO) DIRECTA",
        11 => "(PALACIO) LICITACION PUBLICA INTERNACIONAL",        
    );
    
    public static $pedidoTipos = array(
        1 => 'Pedido',
        2 => 'Orden de Compra',
        3 => 'Contrato',
        4 => 'Otro',
    );
    
    public static $pedidoTiposAdquisiciones = array(
        1 => 'PEDI',
        2 => 'ORDE',
        3 => 'PROP'
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
     * @ORM\Column(name="FolioManual", type="integer", length=2, nullable=true)
     */
    private $folioManual;

    /**
     * @ORM\Column(name="Fecha", type="date", nullable=false)
     */
    private $fecha;

    

    /**
     * @ORM\Column(name="Observaciones", type="string", nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\Column(name="PedidoNumero", type="string", length=6, nullable=false)
     */
    private $pedidoNumero;
    
    /**
     * @ORM\Column(name="Compra", type="smallint", nullable=false)
     */
    private $compra;
    
    /**
     * @ORM\Column(name="AnioEjercicio", type="integer", nullable=false)
     */
    private $anioEjercicio;
    
    /**
     * @ORM\Column(name="tipoCompra", type="smallint", nullable=false)
     */
    private $tipoCompra;
    

    /**
     * @ORM\Column(name="FacturaNumero", type="string", length=10, nullable=true)
     */
    private $facturaNumero;

    /**
     * @ORM\Column(name="FacturaFecha", type="date", nullable=true)
     */
    private $facturaFecha;
    
    /**
     * @ORM\Column(name="NumeroRemision", type="string", length=20, nullable=true)
     */
    private $numeroRemision;

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
     * Set folioManual
     *
     * @param integer $folioManual
     * @return Entradas
     */
    public function setFolioManual($folioManual)
    {
        $this->folioManual = $folioManual;

        return $this;
    }

    /**
     * Get folioManual
     *
     * @return integer 
     */
    public function getFolioManual()
    {
        return $this->folioManual;
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
     * Set compra
     *
     * @param integer $compra
     * @return Entradas
     */
    public function setCompra($compra)
    {
        $this->compra = $compra;

        return $this;
    }

    /**
     * Get compra
     *
     * @return integer 
     */
    public function getCompra()
    {
        return $this->compra;
    }

    /**
     * Set anioEjercicio
     *
     * @param integer $anioEjercicio
     * @return Entradas
     */
    public function setAnioEjercicio($anioEjercicio)
    {
        $this->anioEjercicio = $anioEjercicio;

        return $this;
    }

    /**
     * Get anioEjercicio
     *
     * @return integer 
     */
    public function getAnioEjercicio()
    {
        return $this->anioEjercicio;
    }

    /**
     * Set tipoCompra
     *
     * @param integer $tipoCompra
     * @return Entradas
     */
    public function setTipoCompra($tipoCompra)
    {
        $this->tipoCompra = $tipoCompra;

        return $this;
    }

    /**
     * Get tipoCompra
     *
     * @return integer 
     */
    public function getTipoCompra()
    {
        return $this->tipoCompra;
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
     * Set numeroRemision
     *
     * @param string $numeroRemision
     * @return Entradas
     */
    public function setNumeroRemision($numeroRemision)
    {
        $this->numeroRemision = $numeroRemision;

        return $this;
    }

    /**
     * Get numeroRemision
     *
     * @return string 
     */
    public function getNumeroRemision()
    {
        return $this->numeroRemision;
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
