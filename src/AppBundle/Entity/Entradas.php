<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="Entradas",
 *     indexes={
 *         @ORM\Index(name="FK_EntradasProveedorId_ProveedoresId_idx", columns={"proveedorId"}),
 *         @ORM\Index(name="FK_EntradasProgramaId_ProgramasId_idx", columns={"programaId"}),
 *         @ORM\Index(name="FK_EntradasEjercicioId_EjerciciosId_idx", columns={"ejercicioId"})
 *     }
 * )
 */
class Entradas
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
     * @ORM\Column(type="integer", length=1, nullable=false)
     */
    private $tipoEntradaId;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $pedidoNumero;

    /**
     * @ORM\Column(type="integer", length=1, nullable=true)
     */
    private $pedidoTipoId;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $numeroFactura;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fechaFactura;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $fechaCreacion;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $fechaActualizacion;
}