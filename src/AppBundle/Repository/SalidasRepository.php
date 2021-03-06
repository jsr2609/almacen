<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class SalidasRepository extends EntityRepository
{
    public function buscar($id, $select = null, $hydrationMode = null)
    {
        if(!$select) {
            $select = "sls, pgs, ecs, dts";
        }
        
        if(!$hydrationMode) {
            $hydrationMode = 'HYDRATE_OBJECT';
        }
        
        $qb = $this->createQueryBuilder('sls');
        
        $qb->select($select)
            ->innerJoin('sls.programa', 'pgs')
            ->innerJoin('sls.ejercicio', 'ecs')   
            ->innerJoin('sls.destino', 'dts')
            ->innerJoin('ecs.almacen', 'ams')
            ->andWhere('sls.id = :id')
            ->setParameter('id', $id)
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
    
    
    
    public function contarEnSalidas($salidaId)
    {
        $dql = "SELECT COUNT(sds.id) FROM AppBundle:SalidaDetalles AS sds "
                . "INNER JOIN sds.salida AS sls "
                . "WHERE sds.salida = :salida";
        
        $q = $this->getEntityManager()->createQuery($dql)
                ->setParameter('salida', $salidaId);
        
        return $q->getSingleScalarResult();
    }
}
