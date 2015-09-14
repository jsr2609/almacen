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
       
    }

    public function getOrder() 
    {
        return 5;
    }

//put your code here
}
