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
     * @ORM\Column(name="Id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="Folio", type="integer", length=2, nullable=false)
     */
    private $folio;

    /**
     * @ORM\Column(name="Fecha", type="date", nullable=false)
     */
    private $fecha;

    /**
     * @ORM\Column(name="TipoEntradaId", type="integer", length=2, nullable=false)
     */
    private $tipoEntradaId;

    /**
     * @ORM\Column(name="NombreQuienRecibe", type="string", length=150, nullable=false)
     */
    private $nombreQuienRecibe;

    /**
     * @ORM\Column(name="AreaQueRecibe", type="string", length=150, nullable=false)
     */
    private $areaQueRecibe;

    /**
     * @ORM\Column(name="Observaciones", type="string", nullable=true)
     */
    private $observaciones;

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