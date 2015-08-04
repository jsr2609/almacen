<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table()
 */
class VwEntradas
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
     * @ORM\Column(name="Folio", type="integer")
     */
    private $folio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Fecha", type="date")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="PedidoNumero", type="string", length=10)
     */
    private $pedidoNumero;
    
    /**
     * @ORM\Column(name="Compra", type="string", length=5, nullable=false)
     */
    private $compra;
    
    /**
     * @ORM\Column(name="AnioEjercicio", type="integer", nullable=false)
     */
    private $anioEjercicio;

    /**
     * @var string
     *
     * @ORM\Column(name="FacturaNumero", type="string", length=10)
     */
    private $facturaNumero;

    /**
     * @var integer
     *
     * @ORM\Column(name="EjercicioId", type="integer")
     */
    private $ejercicio;
    
    /**
     * @ORM\Column(name="Activa", type="boolean", nullable=false)
     */
    private $activa = true;


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
     * @return VwEntradas
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
     * @return VwEntradas
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
     * Set pedidoNumero
     *
     * @param string $pedidoNumero
     * @return VwEntradas
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
     * @param string $compra
     * @return VwEntradas
     */
    public function setCompra($compra)
    {
        $this->compra = $compra;

        return $this;
    }

    /**
     * Get compra
     *
     * @return string 
     */
    public function getCompra()
    {
        return $this->compra;
    }

    /**
     * Set anioEjercicio
     *
     * @param integer $anioEjercicio
     * @return VwEntradas
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
     * Set facturaNumero
     *
     * @param string $facturaNumero
     * @return VwEntradas
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
     * Set ejercicio
     *
     * @param integer $ejercicio
     * @return VwEntradas
     */
    public function setEjercicio($ejercicio)
    {
        $this->ejercicio = $ejercicio;

        return $this;
    }

    /**
     * Get ejercicio
     *
     * @return integer 
     */
    public function getEjercicio()
    {
        return $this->ejercicio;
    }

    /**
     * Set activa
     *
     * @param boolean $activa
     * @return VwEntradas
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
}
