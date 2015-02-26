<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Conceptos")
 */
class Conceptos
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", length=2)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150, nullable=false)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="string", length=45, nullable=false)
     */
    private $activo;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $fechaCreacion;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $fechaActualizacion;
}