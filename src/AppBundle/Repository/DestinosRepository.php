<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class DestinosRepository extends EntityRepository
{
    public function recuperarListaDestinos($select = null)
    {
        $qb = $this->createQueryBuilder('pgs');
        if($select) {
            $qb->select();
        }
        
        return $qb->getQuery()->getArrayResult();
        
    }
}
