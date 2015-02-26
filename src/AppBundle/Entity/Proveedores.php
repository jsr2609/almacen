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
     * @ORM\Column(name="Id", type="integer", length=2)
     */
    private $id;

    /**
     * @ORM\Column(name="Nombre", type="string", length=150, nullable=false)
     */
    private $nombre;

    /**
     * @ORM\Column(name="FechaCreacion", type="date", nullable=false)
     */
    private $fechaCreacion;

    /**
     * @ORM\Column(name="FechaActualizacion", type="date", nullable=false)
     */
    private $fechaActualizacion;
}