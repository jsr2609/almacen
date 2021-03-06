<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class EntradasRepository extends EntityRepository
{
    public function buscar($id, $select = null, $hydrationMode = null)
    {
        if(!$select) {
            $select = "ets, pgs, pvs, ecs";
        }
        
        if(!$hydrationMode) {
            $hydrationMode = 'HYDRATE_OBJECT';
        }
        
        $qb = $this->createQueryBuilder('ets');
        
        $qb->select($select)
            ->innerJoin('ets.programa', 'pgs')
            ->innerJoin('ets.proveedor', 'pvs')
            ->innerJoin('ets.ejercicio', 'ecs')
            ->innerJoin('ecs.almacen', 'ams')
            ->andWhere('ets.id = :id')
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
        
    public function contarEnSalidas($entradaId)
    {
        $dql = "SELECT COUNT(sds.id) FROM AppBundle:SalidaDetalles AS sds "
                . "INNER JOIN sds.entradaDetalle AS eds "
                . "INNER JOIN eds.entrada AS ets "
                . "WHERE ets.id = :entrada";
        
        $q = $this->getEntityManager()->createQuery($dql)
                ->setParameter('entrada', $entradaId);
        
        return $q->getSingleScalarResult();
    }
    
    
    public function recuperarListaEntradasDirectas($programaId)
    {
        $select = "ets";
        $qb = $this->createQueryBuilder('ets');
        if($select) {
            $qb->select($select)
            ->groupBy('ets')
            ->leftJoin('AppBundle:EntradaDetalles', 'eds', 'WITH', 'eds.entrada = ets.id')
            ->leftJoin('AppBundle:SalidaDetalles', 'sds', 'WITH', 'sds.entradaDetalle = eds.id')
            ->where('sds.id is null')
            ->andWhere('ets.tipoCompra = 1')
            ->andWhere('ets.programa = :programa')
            ->setParameter('programa', $programaId);
       }
       
       return $qb->getQuery()->getResult();
       
    }
    
}
