<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="SalidaDetalles")
 */
class SalidaDetalles
{
    /**
     * @ORM\Id
     * @ORM\Column(name="Id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
     /**
     * @ORM\ManyToOne(targetEntity="Salidas")
     * @ORM\JoinColumn(name="SalidaId", referencedColumnName="Id", nullable=false, onDelete="RESTRICT")
    */
    private $salida;
    
     /**
     * @ORM\ManyToOne(targetEntity="Articulos")
     * @ORM\JoinColumn(name="ArticuloId", referencedColumnName="Id", nullable=false, onDelete="RESTRICT")
    */
    private $articulo;

    /**
     * @ORM\Column(name="Cantidad", type="integer", nullable=false)
     */
    private $cantidad;

    /**
     * @ORM\Column(name="Activo", type="boolean", nullable=false)
     */
    private $activo = true;

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