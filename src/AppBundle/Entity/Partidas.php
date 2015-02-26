<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="Partidas",
 *     indexes={@ORM\Index(name="FK_PartidasConceptoId_ConceptosId_idx", columns={"conceptoId"})}
 * )
 */
class Partidas
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
     * @ORM\Column(name="Descripcion", type="string", nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(name="Prefijo", type="string", length=5, nullable=false)
     */
    private $prefijo;

    /**
     * @ORM\Column(name="FechaCreacion", type="date", nullable=false)
     */
    private $fechaCreacion;

    /**
     * @ORM\Column(name="FechaActualizacion", type="date", nullable=false)
     */
    private $fechaActualizacion;

    /**
     * @ORM\Column(name="Activo", type="boolean", nullable=false)
     */
    private $activo;
}