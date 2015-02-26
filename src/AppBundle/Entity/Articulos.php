<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Articulos", indexes={@ORM\Index(name="FK_ArticulosPartidaId_idx", columns={"partidaId"})})
 */
class Articulos
{
    /**
     * @ORM\Id
     * @ORM\Column(name="Id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="Clave", type="string", length=15, nullable=false)
     */
    private $clave;

    /**
     * @ORM\Column(name="Nombre", type="string", length=45, nullable=false)
     */
    private $nombre;

    /**
     * @ORM\Column(name="PresentacionId", type="integer", length=2, nullable=false)
     */
    private $presentacionId;

    /**
     * @ORM\Column(name="Cantidad", type="integer", length=2, nullable=true)
     */
    private $cantidad;

    /**
     * @ORM\Column(name="UnidadMedidaPresentacion", type="string", length=45, nullable=true)
     */
    private $unidadMedidaPresentacion;

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