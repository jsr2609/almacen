<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VwArticulos
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class VwArticulos
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
     * @var string
     *
     * @ORM\Column(name="Clave", type="string", length=15)
     */
    private $clave;

    /**
     * @var string
     *
     * @ORM\Column(name="Nombre", type="text")
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="PartidaClave", type="string", length=6)
     */
    private $partidaClave;

    /**
     * @var string
     *
     * @ORM\Column(name="PartidaNombre", type="string", length=150)
     */
    private $partidaNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="PresentacionNombre", type="string", length=50)
     */
    private $presentacionNombre;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="Activo", type="boolean")
     */
    private $activo;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function getActivo()
    {
        return $this->getActivo();
    }

    /**
     * Set clave
     *
     * @param string $clave
     * @return VwArticulos
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get clave
     *
     * @return string 
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return VwArticulos
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set partidaClave
     *
     * @param string $partidaClave
     * @return VwArticulos
     */
    public function setPartidaClave($partidaClave)
    {
        $this->partidaClave = $partidaClave;

        return $this;
    }

    /**
     * Get partidaClave
     *
     * @return string 
     */
    public function getPartidaClave()
    {
        return $this->partidaClave;
    }

    /**
     * Set partidaNombre
     *
     * @param string $partidaNombre
     * @return VwArticulos
     */
    public function setPartidaNombre($partidaNombre)
    {
        $this->partidaNombre = $partidaNombre;

        return $this;
    }

    /**
     * Get partidaNombre
     *
     * @return string 
     */
    public function getPartidaNombre()
    {
        return $this->partidaNombre;
    }

    /**
     * Set presentacionNombre
     *
     * @param string $presentacionNombre
     * @return VwArticulos
     */
    public function setPresentacionNombre($presentacionNombre)
    {
        $this->presentacionNombre = $presentacionNombre;

        return $this;
    }

    /**
     * Get presentacionNombre
     *
     * @return string 
     */
    public function getPresentacionNombre()
    {
        return $this->presentacionNombre;
    }
}
