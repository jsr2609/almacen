<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="EntradaDetalles",
 *     indexes={
 *         @ORM\Index(name="FK_ENTRADA_ID_idx", columns={"entradaId"}),
 *         @ORM\Index(name="FK_EntradaDetallesArticuloId_ArticulosId_idx", columns={"articuloId"})
 *     }
 * )
 */
class EntradaDetalles
{
    /**
     * @ORM\Id
     * @ORM\Column(name="Id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="Cantidad", type="integer", length=2, nullable=false)
     */
    private $cantidad;

    /**
     * @ORM\Column(name="Precio", type="decimal", nullable=false)
     */
    private $precio;

    /**
     * @ORM\Column(name="AplicaIVA", type="boolean", nullable=true)
     */
    private $aplicaIVA;

    /**
     * @ORM\Column(name="Observaciones", type="string", nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\Column(name="FechaCreacion", type="date", nullable=false)
     */
    private $fechaCreacion;

    /**
     * @ORM\Column(name="FechaActualizacion", type="date", nullable=true)
     */
    private $fechaActualizacion;
}