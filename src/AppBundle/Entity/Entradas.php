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
     * @ORM\Column(name="TipoEntradaId", type="integer", length=1, nullable=false)
     */
    private $tipoEntradaId;

    /**
     * @ORM\Column(name="Observaciones", type="string", nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\Column(name="PedidoNumero", type="string", length=10, nullable=true)
     */
    private $pedidoNumero;

    /**
     * @ORM\Column(name="PedidoTipoId", type="integer", length=1, nullable=true)
     */
    private $pedidoTipoId;

    /**
     * @ORM\Column(name="NumeroFactura", type="string", length=10, nullable=true)
     */
    private $numeroFactura;

    /**
     * @ORM\Column(name="FechaFactura", type="date", nullable=true)
     */
    private $fechaFactura;

    /**
     * @ORM\Column(name="FechaCreacion", type="date", nullable=false)
     */
    private $fechaCreacion;

    /**
     * @ORM\Column(name="FechaActualizacion", type="date", nullable=false)
     */
    private $fechaActualizacion;
}