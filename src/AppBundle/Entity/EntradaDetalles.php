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
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", length=2, nullable=false)
     */
    private $cantidad;

    /**
     * @ORM\Column(type="decimal", nullable=false)
     */
    private $precio;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $aplicaIVA;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $fechaCreacion;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fechaActualizacion;
}