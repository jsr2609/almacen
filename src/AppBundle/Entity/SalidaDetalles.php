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
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $cantidad;

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