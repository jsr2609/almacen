<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="SalidaDetalles",
 *     indexes={
 *         @ORM\Index(name="FK_SalidaDetallesSalidaId_SalidasId_idx", columns={"salidaId"}),
 *         @ORM\Index(name="FK_SalidaDetallesArticuloId_ArticulosId_idx", columns={"articuloId"})
 *     }
 * )
 */
class SalidaDetalles
{
    /**
     * @ORM\Id
     * @ORM\Column(name="Id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="Cantidad", type="integer", nullable=false)
     */
    private $cantidad;

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