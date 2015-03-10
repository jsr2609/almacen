<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

use AppBundle\Entity\EntradaTipos;

/**
 * Description of LoadRolesData
 *
 * @author jsr
 */
class LoadEntradaTiposData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager) 
    {
        $entidad1 = new EntradaTipos();
        $entidad1->setNombre("Directa");
        $manager->persist($entidad1);
        
        $entidad2 = new EntradaTipos();
        $entidad2->setNombre("Donación");
        $manager->persist($entidad2);
        
        $entidad3 = new EntradaTipos();
        $entidad3->setNombre("Licitación");
        $manager->persist($entidad3);
        
        $entidad4 = new EntradaTipos();
        $entidad4->setNombre("Otra");
        $manager->persist($entidad4);
        
        $manager->flush();
    }

    public function getOrder() 
    {
        return 5;
    }

//put your code here
}
