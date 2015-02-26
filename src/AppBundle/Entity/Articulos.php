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
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15, nullable=false)
     */
    private $clave;

    /**
     * @ORM\Column(type="string", length=45, nullable=false)
     */
    private $nombre;

    /**
     * @ORM\Column(type="integer", length=2, nullable=false)
     */
    private $presentacionId;

    /**
     * @ORM\Column(type="integer", length=2, nullable=true)
     */
    private $cantidad;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $unidadMedidaPresentacion;

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