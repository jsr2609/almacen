<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Grupos
 *
 * @ORM\Table(name="Grupos")
 * @ORM\Entity
 */ 
class Grupos
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
     * @Assert\NotBlank
     * @ORM\Column(name="Nombre", type="string", length=45)
     */
    private $nombre;
    
    /**
     * @var string
     *
     * @ORM\Column(name="Descripcion", type="text", nullable=true)
     */
    private $descripcion;
    
    /**
     * @ORM\ManyToMany(targetEntity="Roles") 
     * @ORM\JoinTable(name="GruposHasRoles",
     *     joinColumns={@ORM\JoinColumn(name="GrupoId", referencedColumnName="Id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="PermisoId", referencedColumnName="Id")}
     * )
     */
    
    private $roles;
    
    public function __toString() {
        return $this->nombre;
    }
    
    public function getRoles($b = false)
    {
        if(!$b) {
            return $this->roles;
        }
        $roles = array();
        
        foreach($this->roles as $rol) {
            $roles[] = $rol->getNombre();
        }
        
        return $roles;
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     * @return Grupos
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Grupos
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Add roles
     *
     * @param \AppBundle\Entity\Roles $roles
     * @return Grupos
     */
    public function addRole(\AppBundle\Entity\Roles $roles)
    {
        $this->roles[] = $roles;

        return $this;
    }

    /**
     * Remove roles
     *
     * @param \AppBundle\Entity\Roles $roles
     */
    public function removeRole(\AppBundle\Entity\Roles $roles)
    {
        $this->roles->removeElement($roles);
    }
}
