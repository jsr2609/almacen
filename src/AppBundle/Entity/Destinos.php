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
     * @ORM\Column(type="integer", length=2)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150, nullable=false)
     */
    private $nombre;
}