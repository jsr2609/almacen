<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="Salidas",
 *     indexes={
 *         @ORM\Index(name="FK_SalidasEjercicioId_EjerciciosId_idx", columns={"ejercicioId"}),
 *         @ORM\Index(name="FK_SalidasProgramaId_ProgramaId_idx", columns={"programaId"}),
 *         @ORM\Index(name="FK_SalidasProgramaId_DestinosId_idx", columns={"destinoId"})
 *     }
 * )
 */
class Salidas
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", length=2, nullable=false)
     */
    private $folio;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $fecha;

    /**
     * @ORM\Column(type="integer", length=2, nullable=false)
     */
    private $tipoEntradaId;

    /**
     * @ORM\Column(type="string", length=150, nullable=false)
     */
    private $nombreQuienRecibe;

    /**
     * @ORM\Column(type="string", length=150, nullable=false)
     */
    private $areaQueRecibe;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\Column(type="boolean", nullable=false)
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