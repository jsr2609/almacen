<?php

namespace SSA\SeguridadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Perfiles
 *
 * @ORM\Table(name="Perfiles")
 * @ORM\Entity
 */
class Perfiles
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
     * @ORM\OneToOne(targetEntity="Usuarios", inversedBy="perfil")
     * @ORM\JoinColumn(name="UsuarioId", onDelete="CASCADE", nullable=false, referencedColumnName="Id")
     */
    private $usuario;

    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Almacenes")
     * @ORM\JoinColumn(name="AlmacenId", referencedColumnName="Id", nullable=false, onDelete="RESTRICT")
     */
    private $almacen;
    
    /* Getters y Setters */

    


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
     * Set usuario
     *
     * @param \SSA\SeguridadBundle\Entity\Usuarios $usuario
     * @return Perfiles
     */
    public function setUsuario(\SSA\SeguridadBundle\Entity\Usuarios $usuario = null)
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

    /**
     * Set almacen
     *
     * @param \AppBundle\Entity\Almacenes $almacen
     * @return Perfiles
     */
    public function setAlmacen(\AppBundle\Entity\Almacenes $almacen)
    {
        $this->almacen = $almacen;

        return $this;
    }

    /**
     * Get almacen
     *
     * @return \AppBundle\Entity\Almacenes 
     */
    public function getAlmacen()
    {
        return $this->almacen;
    }
}
