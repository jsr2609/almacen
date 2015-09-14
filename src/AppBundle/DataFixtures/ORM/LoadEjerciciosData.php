<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

use AppBundle\Entity\Almacenes;
use AppBundle\Entity\Ejercicios;

/**
 * Description of LoadRolesData
 *
 * @author jsr
 */
class LoadEjerciciosData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager) 
    {
        $entidad = new Ejercicios();
        $entidad->setAlmacen($this->getReference('almacen-central'));
        $entidad->setPeriodo(date('Y'));
        $entidad->setNumeroEntradas(0);
        $entidad->setNumeroSalidas(0);
        $entidad->setIva(16);
        $entidad->setTipoInventario(1);
        $manager->persist($entidad);
        $manager->flush();
        
        
    }

    public function getOrder() 
    {
        return 6;
    }

//put your code here
}
