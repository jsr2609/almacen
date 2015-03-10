<?php

namespace SSA\SeguridadBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

use SSA\SeguridadBundle\Entity\Roles;

/**
 * Description of LoadRolesData
 *
 * @author jsr
 */
class LoadRolesData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager) 
    {
        $role = new Roles();
        $role->setNombre("ROLE_ADMIN");
        $manager->persist($role);
        $manager->flush();
        
        $this->addReference('role-admin', $role);
    }

    public function getOrder() 
    {
        return 1;
    }

//put your code here
}
