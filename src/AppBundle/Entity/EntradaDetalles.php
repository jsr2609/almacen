<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EntradaDetallesRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="ArticuloIdEntradaId_U", columns={"ArticuloId", "EntradaId"})
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
     * @ORM\ManyToOne(targetEntity="Articulos")
     * @ORM\JoinColumn(name="ArticuloId", referencedColumnName="Id", nullable=false, onDelete="RESTRICT")
    */
    private $articulo;
    
    
    /**
     * @ORM\Column(name="Cantidad", type="integer", length=2, nullable=false)
     */
    private $cantidad;
    
    /**
     * @ORM\Column(name="Existencia", type="integer", length=2, nullable=false)
     */
    private $existencia;

    /**
     * @ORM\Column(name="Precio", type="decimal", nullable=false, precision=14, scale=2)
     */
    private $precio;
    
    /**
     * @ORM\Column(name="FechaCaducidad", type="date", nullable=true)
     */
    private $fechaCaducidad;

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
     * Set cantidad
     *
     * @param integer $cantidad
     * @return EntradaDetalles
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
     * Set precio
     *
     * @param string $precio
     * @return EntradaDetalles
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return string 
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set aplicaIva
     *
     * @param boolean $aplicaIva
     * @return EntradaDetalles
     */
    public function setAplicaIva($aplicaIva)
    {
        $this->aplicaIva = $aplicaIva;

        return $this;
    }

    /**
     * Get aplicaIva
     *
     * @return boolean 
     */
    public function getAplicaIva()
    {
        return $this->aplicaIva;
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

    /**
     * Set articulo
     *
     * @param \AppBundle\Entity\Articulos $articulo
     * @return EntradaDetalles
     */
    public function setArticulo(\AppBundle\Entity\Articulos $articulo)
    {
        $this->articulo = $articulo;

        return $this;
    }

    /**
     * Get articulo
     *
     * @return \AppBundle\Entity\Articulos 
     */
    public function getArticulo()
    {
        return $this->articulo;
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
}
