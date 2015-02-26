<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Proveedores")
 */
class Proveedores
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
     * @ORM\Column(type="date", nullable=false)
     */
    private $fechaCreacion;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $fechaActualizacion;
}