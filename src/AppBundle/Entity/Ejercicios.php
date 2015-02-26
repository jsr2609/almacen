<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="Ejercicios",
 *     indexes={@ORM\Index(name="FK_EjerciciosAlmacenId_AlmacenesId_idx", columns={"almacenId"})}
 * )
 */
class Ejercicios
{
    /**
     * @ORM\Id
     * @ORM\Column(name="Id", type="integer", length=2)
     */
    private $id;

    /**
     * @ORM\Column(name="NumeroEntradas", type="integer", length=2, nullable=false)
     */
    private $numeroEntradas;

    /**
     * @ORM\Column(name="NumeroSalidas", type="integer", length=2, nullable=false)
     */
    private $numeroSalidas;

    /**
     * @ORM\Column(name="IVA", type="integer", length=1, nullable=false)
     */
    private $iVA;

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