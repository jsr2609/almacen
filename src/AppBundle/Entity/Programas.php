<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Programas", uniqueConstraints={@ORM\UniqueConstraint(name="Clave_UNIQUE", columns={"Clave"})})
 */
class Programas
{
    /**
     * @ORM\Id
     * @ORM\Column(name="Id", type="integer", length=2)
     */
    private $id;

    /**
     * @ORM\Column(name="Nombre", type="string", length=150, nullable=false)
     */
    private $nombre;

    /**
     * @ORM\Column(name="Clave", type="string", length=10, nullable=false)
     */
    private $clave;

    /**
     * @ORM\Column(name="Activo", type="boolean", nullable=false)
     */
    private $activo;

    /**
     * @ORM\Column(name="FechaCreacion", type="date", nullable=false)
     */
    private $fechaCreacion;

    /**
     * @ORM\Column(name="FechaActualizacion", type="date", nullable=false)
     */
    private $fechaActualizacion;
}