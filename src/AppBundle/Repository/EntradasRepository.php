<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class EntradasRepository extends EntityRepository
{
    public function contarEnSalidas($entradaId)
    {
        $dql = "SELECT COUNT(sds.id) FROM AppBundle:SalidaDetalles AS sds "
                . "INNER JOIN sds.entradaDetalle AS eds "
                . "INNER JOIN eds.entrada AS eta "
                . "WHERE eta.id = :entrada";
        
        $q = $this->getEntityManager()->createQuery($dql)
                ->setParameter('entrada', $entradaId);
        
        return $q->getSingleScalarResult();
    }
}
