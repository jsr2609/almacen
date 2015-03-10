<?php

namespace SSA\SeguridadBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use SSA\SeguridadBundle\Entity\Usuarios;
use SSA\SeguridadBundle\Entity\Perfiles;

/**
 * Description of LoadRolesData
 *
 * @author jsr
 */
class LoadUsuariosData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;
    
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    public function load(ObjectManager $manager) 
    {
        $entidad = new Usuarios();
        $entidad->setUsuario("admin");
        
        $encoder = $this->container
            ->get('security.encoder_factory')
            ->getEncoder($entidad)
        ;
        $entidad->setPassword($encoder->encodePassword('0101', $entidad->getSalt()));
        
        $entidad->setEmail("admin@admin.com");
        $entidad->setNombre("Administrador");
        $entidad->setApellidoMaterno("del");
        $entidad->setApellidoPaterno("Sistema");
        
        $perfil = new Perfiles();
        $perfil->setUsuario($entidad);
        $perfil->setAlmacen($this->getReference('almacen-central'));
        
        $entidad->setPerfil($perfil);
        $entidad->addGrupo($this->getReference("grupo-admin"));
        
        $manager->persist($entidad);
        $manager->flush();        
    }

    public function getOrder() 
    {
        return 4;
    }

//put your code here
}
