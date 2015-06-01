<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class ArticulosRepository extends EntityRepository
{
    public function buscar($valor, $select = null, $campo = "clave", $hydrationMode = 'HYDRATE_OBJECT')
    {
        $qb = $this->createQueryBuilder('ats');
        
    }
}
