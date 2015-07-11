<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class ArticulosRepository extends EntityRepository
{
    public function buscar($valor, $select = null, $campo = "clave", $hydrationMode = 'HYDRATE_OBJECT')
    {
        $qb = $this->createQueryBuilder('ats');
        
        if($select) {
            $qb->select($select);
        } else {
            $qb->select('ats');
        }
        
        $qb->andWhere('ats.'.$campo.' = :valor')
            ->setParameter('valor', $valor);
        
        ;
        $query = $qb->getQuery();
        
        switch($hydrationMode) {
            case "HYDRATE_ARRAY":
                $hydration = $query::HYDRATE_ARRAY;
                break;
            
            case "HYDRATE_OBJECT":
                $hydration = $query::HYDRATE_OBJECT;
                break;
            
        }
        
        try {
            return $query->getSingleResult($hydration);
        } catch (NoResultException $ex) {
            return null;
        }
        
    }
}
