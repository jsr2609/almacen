<?php

namespace SSA\SeguridadBundle\Repository;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class UsuariosRepository extends EntityRepository implements UserProviderInterface
{
    public function loadUserByUsername($value) {        
        $q = $this
            ->createQueryBuilder('usr')
            ->select('usr','gps', 'rls', 'prl')
            ->where('usr.usuario = :value')
            ->setParameter('value', $value)
            ->leftJoin('usr.grupos', 'gps')
            ->leftJoin('gps.roles', 'rls')
            ->leftJoin('usr.perfil', 'prl')
            //->leftJoin('u.permissions', 'e')
            
            ->getQuery()
        ;

        try {
            // The Query::getSingleResult() method throws an exception
            // if there is no record matching the criteria.
            $user = $q->getSingleResult();
        } catch (NoResultException $e) {
            $message = sprintf(
                'Unable to find an active admin AcmeUserBundle:User object identified by "%s".',
                $value
            );
            throw new UsernameNotFoundException($message, 0, $e);
        }

        return $user;
    }

    public function refreshUser(UserInterface $user) {        
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(
                sprintf(
                    'Instances of "%s" are not supported.',
                    $class
                )
            );
            
            
        }
        
        return $this->find($user->getId());
    }

    public function supportsClass($class) {
        return $this->getEntityName() === $class
            || is_subclass_of($class, $this->getEntityName());
    }
    
    public function recuperarPassword($usuarioId)
    {
        $dql = "SELECT usr.password FROM SSASeguridadBundle:Usuarios usr WHERE "
                . "usr.id = :id";        
        $consulta = $this->getEntityManager()->createQuery($dql);        
        $consulta->setParameter(':id', $usuarioId);
        
        return $consulta->getSingleScalarResult();
    }
}
