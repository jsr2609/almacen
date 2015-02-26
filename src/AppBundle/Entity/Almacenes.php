<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Almacenes")
 */
class Almacenes
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
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $domicilio;

    /**
     * @ORM\Column(type="string", length=150, nullable=false)
     */
    private $nombreResponsableAlmacen;

    /**
     * @ORM\Column(type="string", length=150, nullable=false)
     */
    private $cargoResponsableAlmacen;

    /**
     * @ORM\Column(type="string", length=150, nullable=false)
     */
    private $nombreRecursosMateriales;

    /**
     * @ORM\Column(type="string", length=150, nullable=false)
     */
    private $cargoRecursosMateriales;

    /**
     * @ORM\Column(type="string", length=150, nullable=false)
     */
    private $nombreJefeServicios;

    /**
     * @ORM\Column(type="string", length=150, nullable=false)
     */
    private $lugar;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $fechaCreacion;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $fechaActualizacion;
}