<?php

namespace SSA\SeguridadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Usuarios
 *
 * @ORM\Table(name="Usuarios")
 * @ORM\Entity(repositoryClass="SSA\SeguridadBundle\Repository\UsuariosRepository")
 */
class Usuarios implements AdvancedUserInterface, \Serializable
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
     * @Assert\NotBlank(groups={"nuevo", "edicion"})
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9_]{3,16}$/",
     *     match=true,
     *     message="Proporciona un nombre de usuario valido",
     *     groups={"nuevo", "edicion"}
     * )
     * @ORM\Column(name="Usuario", type="string", length=45, unique=true)
     */
    private $usuario;
    
    /**
     * @var string
     * @Assert\NotBlank(groups={"nuevo"})
     * @ORM\Column(name="Password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;

    /**
     * @var string
     * @Assert\NotBlank(groups={"nuevo", "edicion"})
     * @Assert\Email(groups={"nuevo", "edicion"})
     *
     * @ORM\Column(name="Email", type="string", length=60)
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Activo", type="boolean")
     */
    private $activo = true;
    
    /**
     * @var string
     * @Assert\NotBlank(groups={"nuevo", "edicion"})
     * @ORM\Column(name="Nombre", type="string", length=45)
     */
    private $nombre;
    
    /**
     * @var string
     * @Assert\NotBlank(groups={"nuevo", "edicion"})
     * @ORM\Column(name="apellidoPaterno", type="string", length=45)
     */
    private $apellidoPaterno;
    
    /**
     * @var string
     * @Assert\NotBlank(groups={"nuevo", "edicion"})
     * @ORM\Column(name="apellidoMaterno", type="string", length=45)
     */
    private $apellidoMaterno;
    
    
    /**
     * @ORM\ManyToMany(targetEntity="Grupos") 
     * @ORM\JoinTable(name="UsuariosHasGrupos",
     *     joinColumns={@ORM\JoinColumn(name="UsuarioId", referencedColumnName="Id", onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="GrupoId", referencedColumnName="Id")}
     * )
     */
    private $grupos;
    
    /**
     * @ORM\OneToOne(targetEntity="Perfiles", mappedBy="usuario", cascade="ALL")
     */
    private $perfil;    
    
    /**
     * @ORM\Column(name="FechaCreacion", type="datetime", nullable=false)
     */
    private $fechaCreacion;

    /**
     * @ORM\Column(name="FechaActualizacion", type="datetime", nullable=false)
     */
    private $fechaActualizacion;
    
    public function getNombreCompleto()
    {
        return $this->nombre." ".$this->apellidoPaterno." ".$this->apellidoMaterno;
    }
    
    public function __construct()
    {
        $this->activo = true;
        $this->salt = md5(uniqid(null, true));
        $this->grupos = new ArrayCollection();
        $this->fechaCreacion = new \DateTime();
        $this->fechaActualizacion = new \DateTime();
        
    }
    
    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->usuario;
    }
    
    

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        $roles = array("ROLE_USER");
        
        foreach($this->grupos as $grupo) {
            foreach($grupo->getRoles(1) as $rol) {
                if(!in_array($rol, $roles)) {
                    $roles[] = "ROLE_".strtoupper($rol);
                }
            }
        }
        
        return $roles;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
        ) = unserialize($serialized);
    }
    
    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->activo;
    }
    
    public function __toString() {
        return $this->nombre;
    }
   
    
    /** Getters y Setters */
    

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
     * @param string $usuario
     * @return Usuarios
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return string 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Usuarios
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return Usuarios
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Usuarios
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Usuarios
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean 
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Usuarios
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
     * Set apellidoPaterno
     *
     * @param string $apellidoPaterno
     * @return Usuarios
     */
    public function setApellidoPaterno($apellidoPaterno)
    {
        $this->apellidoPaterno = $apellidoPaterno;

        return $this;
    }

    /**
     * Get apellidoPaterno
     *
     * @return string 
     */
    public function getApellidoPaterno()
    {
        return $this->apellidoPaterno;
    }

    /**
     * Set apellidoMaterno
     *
     * @param string $apellidoMaterno
     * @return Usuarios
     */
    public function setApellidoMaterno($apellidoMaterno)
    {
        $this->apellidoMaterno = $apellidoMaterno;

        return $this;
    }

    /**
     * Get apellidoMaterno
     *
     * @return string 
     */
    public function getApellidoMaterno()
    {
        return $this->apellidoMaterno;
    }

    /**
     * Set fechaActualizacion
     *
     * @param \DateTime $fechaActualizacion
     * @return Usuarios
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
     * Add grupos
     *
     * @param \SSA\SeguridadBundle\Entity\Grupos $grupos
     * @return Usuarios
     */
    public function addGrupo(\SSA\SeguridadBundle\Entity\Grupos $grupos)
    {
        $this->grupos[] = $grupos;

        return $this;
    }

    /**
     * Remove grupos
     *
     * @param \SSA\SeguridadBundle\Entity\Grupos $grupos
     */
    public function removeGrupo(\SSA\SeguridadBundle\Entity\Grupos $grupos)
    {
        $this->grupos->removeElement($grupos);
    }

    /**
     * Get grupos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGrupos()
    {
        return $this->grupos;
    }

    /**
     * Set perfil
     *
     * @param \SSA\SeguridadBundle\Entity\Perfiles $perfil
     * @return Usuarios
     */
    public function setPerfil(\SSA\SeguridadBundle\Entity\Perfiles $perfil = null)
    {
        //$perfil->setUsuario($this);
        $this->perfil = $perfil;
        
        return $this;
    }

    /**
     * Get perfil
     *
     * @return \SSA\SeguridadBundle\Entity\Perfiles 
     */
    public function getPerfil()
    {
        return $this->perfil;
    }
}
