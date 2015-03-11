<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class ProveedoresRepository extends EntityRepository
{
    public function recuperarLista($select = null)
    {
        $qb = $this->createQueryBuilder('pvs');
        if($select) {
            $qb->select();
        }
        
        return $qb->getQuery()->getArrayResult();
        
    }
}
