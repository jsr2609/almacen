<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="EntradaDetalles")
 */
class EntradaDetalles
{
    /**
     * @ORM\Id
     * @ORM\Column(name="Id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Entradas")
     * @ORM\JoinColumn(name="EntradaId", referencedColumnName="Id", nullable=false, onDelete="RESTRICT")
    */
    private $entrada;
    
    /**
     * @ORM\ManyToOne(targetEntity="Articulos")
     * @ORM\JoinColumn(name="ArticuloId", referencedColumnName="Id", nullable=false, onDelete="RESTRICT")
    */
    private $articulo;
    
    
    /**
     * @ORM\Column(name="Cantidad", type="integer", length=2, nullable=false)
     */
    private $cantidad;

    /**
     * @ORM\Column(name="Precio", type="decimal", nullable=false)
     */
    private $precio;

    /**
     * @ORM\Column(name="AplicaIVA", type="boolean", nullable=true)
     */
    private $aplicaIva;

    /**
     * @ORM\Column(name="Observaciones", type="string", nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\Column(name="FechaCreacion", type="datetime", nullable=false)
     */
    private $fechaCreacion;

    /**
     * @ORM\Column(name="FechaActualizacion", type="datetime", nullable=true)
     */
    private $fechaActualizacion;
    
    public function __construct() 
    {
        $this->fechaCreacion = new \DateTime();
        $this->fechaActualizacion = new \DateTime();
    }
}