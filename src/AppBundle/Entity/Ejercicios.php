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
     * @ORM\Column(type="integer", length=2)
     */
    private $id;

    /**
     * @ORM\Column(type="integer", length=2, nullable=false)
     */
    private $numeroEntradas;

    /**
     * @ORM\Column(type="integer", length=2, nullable=false)
     */
    private $numeroSalidas;

    /**
     * @ORM\Column(type="integer", length=1, nullable=false)
     */
    private $iVA;

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