<?php

namespace SSA\SeguridadBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

use SSA\SeguridadBundle\Entity\Grupos;

/**
 * Description of LoadRolesData
 *
 * @author jsr
 */
class LoadGruposData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager) 
    {
        $grupo = new Grupos();
        $grupo->setNombre("Administradores");
        $grupo->addRole($this->getReference('role-admin'));
        $manager->persist($grupo);
        $manager->flush();
        
        $this->addReference('grupo-admin', $grupo);
    }

    public function getOrder() 
    {
        return 2;
    }

//put your code here
}
