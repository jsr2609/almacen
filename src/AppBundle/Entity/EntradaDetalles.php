<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EntradaDetallesRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="ArticuloIdEntradaId_U", columns={"ArticuloClave", "EntradaId"})
 *     }
 * )
 */
class EntradaDetalles
{
    
    public static $aplicaIvaOpciones = array(0 => 'No', 1 => 'Si');
    
    /**
     * @ORM\Id
     * @ORM\Column(name="Id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Entradas")
     * @ORM\JoinColumn(name="EntradaId", referencedColumnName="Id", nullable=false, onDelete="CASCADE")
    */
    private $entrada;
    
    /**
     * @ORM\Column(name="ArticuloClave", type="string", length=12, nullable=false)
     */
    private $articulo;
    
    /**
     * @ORM\Column(name="Existencia", type="integer", length=2, nullable=false)
     */
    private $existencia;

    /**
     * @ORM\Column(name="FechaCaducidad", type="date", nullable=true)
     */
    private $fechaCaducidad;
    
    /**
     * @ORM\Column(name="Lote", type="string", length=10, nullable=true)
     */
    private $lote;

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
    
    public function getAplicaIvaTexto() 
    {
        $txt = $this->aplicaIva == false ? "No" : "Si"; 
        return $txt;
    }
    
    
    
    // Inicio de funciones HasLifecycleCallbacks
    
    /**
     * @ORM\PrePersist
     */
    public function copiarCantidadAExistencia()
    {
        $this->existencia = $this->cantidad;
    }
    
    // Fin de funciones HasLifecycleCallbacks
    
    
    /**
     * Funciones generadas automáticamente
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
     * Set articulo
     *
     * @param string $articulo
     * @return EntradaDetalles
     */
    public function setArticulo($articulo)
    {
        $this->articulo = $articulo;

        return $this;
    }

    /**
     * Get articulo
     *
     * @return string 
     */
    public function getArticulo()
    {
        return $this->articulo;
    }

    /**
     * Set existencia
     *
     * @param integer $existencia
     * @return EntradaDetalles
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
     * Set fechaCaducidad
     *
     * @param \DateTime $fechaCaducidad
     * @return EntradaDetalles
     */
    public function setFechaCaducidad($fechaCaducidad)
    {
        $this->fechaCaducidad = $fechaCaducidad;

        return $this;
    }

    /**
     * Get fechaCaducidad
     *
     * @return \DateTime 
     */
    public function getFechaCaducidad()
    {
        return $this->fechaCaducidad;
    }

    /**
     * Set lote
     *
     * @param string $lote
     * @return EntradaDetalles
     */
    public function setLote($lote)
    {
        $this->lote = $lote;

        return $this;
    }

    /**
     * Get lote
     *
     * @return string 
     */
    public function getLote()
    {
        return $this->lote;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return EntradaDetalles
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
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return EntradaDetalles
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
     * @return EntradaDetalles
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
     * Set entrada
     *
     * @param \AppBundle\Entity\Entradas $entrada
     * @return EntradaDetalles
     */
    public function setEntrada(\AppBundle\Entity\Entradas $entrada)
    {
        $this->entrada = $entrada;

        return $this;
    }

    /**
     * Get entrada
     *
     * @return \AppBundle\Entity\Entradas 
     */
    public function getEntrada()
    {
        return $this->entrada;
    }
}
