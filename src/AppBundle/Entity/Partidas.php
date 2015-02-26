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
     * @ORM\Column(type="string", length=5, nullable=false)
     */
    private $prefijo;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $fechaCreacion;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $fechaActualizacion;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $activo;
}