<?php
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Destinos")
 */
class Destinos
{
    /**
     * @ORM\Id
     * @ORM\Column(name="Id", type="integer", length=2)
     */
    private $id;

    /**
     * @ORM\Column(name="Nombre", type="string", length=150, nullable=false)
     */
    private $nombre;
}