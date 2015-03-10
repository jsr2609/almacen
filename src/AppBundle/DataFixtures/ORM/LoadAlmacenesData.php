<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

use AppBundle\Entity\Almacenes;

/**
 * Description of LoadRolesData
 *
 * @author jsr
 */
class LoadAlmacenesData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager) 
    {
        $entidad = new Almacenes();
        $entidad->setNombre("Almacen Central de la Secretaría de Salud");
        $entidad->setDomicilio("-");
        $entidad->setNombreResponsableAlmacen("-");
        $entidad->setCargoResponsableAlmacen("-");
        $entidad->setNombreRecursosMateriales("-");
        $entidad->setCargoRecursosMateriales("-");
        $entidad->setNombreJefeServicios("-");
        $entidad->setLugar("-");
        $manager->persist($entidad);
        $manager->flush();
        
        $this->addReference('almacen-central', $entidad);
    }

    public function getOrder() 
    {
        return 3;
    }

//put your code here
}
