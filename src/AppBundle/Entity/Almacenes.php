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
     * @ORM\Column(name="Id", type="integer", length=2)
     */
    private $id;

    /**
     * @ORM\Column(name="Nombre", type="string", length=150, nullable=false)
     */
    private $nombre;

    /**
     * @ORM\Column(name="Domicilio", type="string", length=255, nullable=false)
     */
    private $domicilio;

    /**
     * @ORM\Column(name="NombreResponsableAlmacen", type="string", length=150, nullable=false)
     */
    private $nombreResponsableAlmacen;

    /**
     * @ORM\Column(name="CargoResponsableAlmacen", type="string", length=150, nullable=false)
     */
    private $cargoResponsableAlmacen;

    /**
     * @ORM\Column(name="NombreRecursosMateriales", type="string", length=150, nullable=false)
     */
    private $nombreRecursosMateriales;

    /**
     * @ORM\Column(name="CargoRecursosMateriales", type="string", length=150, nullable=false)
     */
    private $cargoRecursosMateriales;

    /**
     * @ORM\Column(name="NombreJefeServicios", type="string", length=150, nullable=false)
     */
    private $nombreJefeServicios;

    /**
     * @ORM\Column(name="Lugar", type="string", length=150, nullable=false)
     */
    private $lugar;

    /**
     * @ORM\Column(name="FechaCreacion", type="date", nullable=false)
     */
    private $fechaCreacion;

    /**
     * @ORM\Column(name="FechaActualizacion", type="date", nullable=false)
     */
    private $fechaActualizacion;
}