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
     * @ORM\Column(name="FolioManual", type="string", length=10, nullable=true)
     */
    private $folioManual;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Fecha", type="date")
     */
    private $fecha;

    /**
     * @var integer
     *
     * @ORM\Column(name="TipoCompraId", type="smallint")
     */
    private $tipoCompra;

    /**
     * @var string
     *
     * @ORM\Column(name="PedidoNumero", type="string", length=10)
     */
    private $pedidoNumero;

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
     * @var integer
     *
     * @ORM\Column(name="ProgramaId", type="integer")
     */
    private $programa;

    /**
     * @var string
     *
     * @ORM\Column(name="ProgramaClave", type="string", length=10)
     */
    private $programaClave;

    /**
     * @var string
     *
     * @ORM\Column(name="ProgramaNombre", type="string", length=150)
     */
    private $programaNombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="ProveedorId", type="integer")
     */
    private $proveedor;

    /**
     * @var string
     *
     * @ORM\Column(name="ProveedorRfc", type="string", length=13)
     */
    private $proveedorRfc;

    /**
     * @var string
     *
     * @ORM\Column(name="ProveedorNombre", type="string", length=150)
     */
    private $proveedorNombre;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="Activa", type="boolean")
     */
    private $activa;
    
    public function getActiva()
    {
        return $this->activa;
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
     * Get folio
     *
     * @return string
     */
    public function getFolioManual()
    {
        return $this->folioManual;
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
     * Set tipoEntrada
     *
     * @param integer $tipoEntrada
     * @return VwEntradas
     */
    public function setTipoCompra($tipoEntrada)
    {
        $this->tipoEntrada = $tipoEntrada;

        return $this;
    }

    /**
     * Get tipoEntrada
     *
     * @return integer 
     */
    public function getTipoCompra()
    {
        return $this->tipoCompra;
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
     * Set programa
     *
     * @param integer $programa
     * @return VwEntradas
     */
    public function setPrograma($programa)
    {
        $this->programa = $programa;

        return $this;
    }

    /**
     * Get programa
     *
     * @return integer 
     */
    public function getPrograma()
    {
        return $this->programa;
    }

    /**
     * Set programaClave
     *
     * @param string $programaClave
     * @return VwEntradas
     */
    public function setProgramaClave($programaClave)
    {
        $this->programaClave = $programaClave;

        return $this;
    }

    /**
     * Get programaClave
     *
     * @return string 
     */
    public function getProgramaClave()
    {
        return $this->programaClave;
    }

    /**
     * Set programaNombre
     *
     * @param string $programaNombre
     * @return VwEntradas
     */
    public function setProgramaNombre($programaNombre)
    {
        $this->programaNombre = $programaNombre;

        return $this;
    }

    /**
     * Get programaNombre
     *
     * @return string 
     */
    public function getProgramaNombre()
    {
        return $this->programaNombre;
    }

    /**
     * Set proveedor
     *
     * @param integer $proveedor
     * @return VwEntradas
     */
    public function setProveedor($proveedor)
    {
        $this->proveedor = $proveedor;

        return $this;
    }

    /**
     * Get proveedor
     *
     * @return integer 
     */
    public function getProveedor()
    {
        return $this->proveedor;
    }

    /**
     * Set proveedorRfc
     *
     * @param string $proveedorRfc
     * @return VwEntradas
     */
    public function setProveedorRfc($proveedorRfc)
    {
        $this->proveedorRfc = $proveedorRfc;

        return $this;
    }

    /**
     * Get proveedorRfc
     *
     * @return string 
     */
    public function getProveedorRfc()
    {
        return $this->proveedorRfc;
    }

    /**
     * Set proveedorNombre
     *
     * @param string $proveedorNombre
     * @return VwEntradas
     */
    public function setProveedorNombre($proveedorNombre)
    {
        $this->proveedorNombre = $proveedorNombre;

        return $this;
    }

    /**
     * Get proveedorNombre
     *
     * @return string 
     */
    public function getProveedorNombre()
    {
        return $this->proveedorNombre;
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
}
