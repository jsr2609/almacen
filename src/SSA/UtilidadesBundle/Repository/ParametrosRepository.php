<?php

namespace SSA\UtilidadesBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class ParametrosRepository extends EntityRepository
{
    public function recuperarValorPorNombre($nombre)
    {
        $dql = "SELECT pms.valor FROM SSAUtilidadesBundle:Parametros pms "
                . "WHERE pms.nombre LIKE :nombre";
        $consulta = $this->getEntityManager()->createQuery($dql)
                ->setParameter("nombre", $nombre);
        
        return $consulta->getSingleScalarResult();
    }
}
