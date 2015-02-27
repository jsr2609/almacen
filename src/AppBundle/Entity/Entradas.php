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
     * @ORM\Column(name="TipoEntradaId", type="integer", length=1, nullable=false)
     */
    private $tipoEntradaId;

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
    private $pedidoTipoId;

    /**
     * @ORM\Column(name="NumeroFactura", type="string", length=10, nullable=true)
     */
    private $numeroFactura;

    /**
     * @ORM\Column(name="FechaFactura", type="date", nullable=true)
     */
    private $fechaFactura;

    /**
     * @ORM\Column(name="FechaCreacion", type="date", nullable=false)
     */
    private $fechaCreacion;

    /**
     * @ORM\Column(name="FechaActualizacion", type="date", nullable=false)
     */
    private $fechaActualizacion;
    
     public function __construct() 
    {
        $this->fechaCreacion = new \DateTime();
        $this->fechaActualizacion = new \DateTime();
    }
    
}