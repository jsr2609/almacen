<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class ProgramasRepository extends EntityRepository
{
    public function recuperarLista($select = null)
    {
        $qb = $this->createQueryBuilder('pgs');
        if($select) {
            $qb->select();
        }
        
        return $qb->getQuery()->getArrayResult();
        
    }
}
