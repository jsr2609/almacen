<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class SalidaDetallesRepository extends EntityRepository
{
    private $rootAlias = 'sds';
    
    public function buscarTodos($select = null, $salidaId = null, $partidaId = null, $hydrationMode = 'HYDRATE_ARRAY')
    {
        if(!$select) {
            $select = 'sds, eds, ets, ats, sls, dts';
        }
        $qb = $this->createQueryBuilder('sds');
        $qb->select($select);
        $qb->innerJoin('sds.salida', 'sls')
            ->innerJoin('sds.articulo', 'ats')
            ->innerJoin('sds.entradaDetalle', 'eds')
            ->innerJoin('ats.partida', 'pts')
            ->innerJoin('ats.presentacion', 'pss')
            ->innerJoin('sls.destino', 'dts')
        ;
        if($salidaId) {
            $qb->andWhere('sds.salida = :salida');
            $qb->setParameter('salida', $salidaId);
        }
        if($partidaId) {
            $qb->andWhere('ats.partida = :partida');
            $qb->setParameter('partida', $partidaId);
        }
        
        $query = $qb->getQuery();
        
        switch($hydrationMode) {
            case "HYDRATE_ARRAY":
                $hydration = $query::HYDRATE_ARRAY;
                break;
            
            case "HYDRATE_OBJECT":
                $hydration = $query::HYDRATE_OBJECT;
                break;
            
        }
        
        return $query->getResult($hydration);
    }
    
    public function buscarPorEjercicio($almacen, $periodo, $select = null, $hydrationMode = 'HYDRATE_OBJECT', $root = null)
    {   
        if(!$root) { 
            $root = $this->root;
        }
        
        $qb = $this->createQueryBuilder($root);
        
        if($select) {
            $qb->select($select);
        }
        
        $qb->andWhere($root.".almacen = :almacen")
            ->andWhere($root.'.periodo = :periodo')
            ->setParameters(array(
                'almacen' => $almacen,
                'periodo' => $periodo
            ))
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
        
        return $query->getSingleResult($hydration);
    }
    
    public function obtenerIVAPorAlmacenYPeriodo($almacen, $periodo) {
        $dql = "SELECT ecs.iva FROM AppBundle:Ejercicios ecs WHERE ecs.almacen = :almacen "
                . "AND ecs.periodo = :periodo";
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameters(array(
            'almacen' => $almacen,
            'periodo' => $periodo,
        ));
        
        return $query->getSingleScalarResult();
    }
    
    public function obtenerPartidasPorSalida($salidaId) 
    {
        $dql = "SELECT DISTINCT pts.id, pts.clave, pts.nombre FROM AppBundle:SalidaDetalles sds "
                . "INNER JOIN sds.entradaDetalle AS eds "
                . "INNER JOIN eds.articulo AS ats "
                . "INNER JOIN ats.partida AS pts "
                . "WHERE sds.salida = :salida";
        
        $query = $this->getEntityManager()->createQuery($dql);
        
        $query->setParameter('salida', $salidaId);
        
        return $query->getArrayResult();
    }
    
    public function findAllWJ($category, $select = null, $hydrationMode = null, $user = null)
    {
        $qb = $this->findBaseWJQB($select, $user);
        if($category) {
            $qb->andWhere('t.category = :category')
                ->setParameter('category', $category);
        }
        $query = $qb->getQuery();
        
        switch($hydrationMode) {
            case "HYDRATE_ARRAY":
                $hydration = $query::HYDRATE_ARRAY;
                break;
            
            case "HYDRATE_OBJECT":
                $hydration = $query::HYDRATE_OBJECT;
                break;
            
        }
        
        return $query->getResult($hydration);
    }
    
    /**
     * 
     * Busca los registros para kardex
     */
    public function buscarParaKardex($articulo, $select = null, $programa = null, $fInicial = null, $fFinal = null, $tipoInventario = 1)
    {
        $qb = $this->createQueryBuilder('sds');
        $qb->innerJoin('sds.salida', 'sls')
            ->innerJoin('sls.destino', 'dts');
        
        $select = ($select === null) ? 'sds, sls' : $select;
        
        $qb->select($select)
            ->andWhere('sds.articulo = :articulo')
            ->setParameter('articulo', $articulo)
        ;
        
        //PEPS
        if($tipoInventario == 1) {
            $qb->innerJoin('sds.entradaDetalle', 'eds');
            //$qb->addSelect('eds');
            if(!$select) {
                $qb->addSelect('sls');
            }
        }
        
        if($tipoInventario == 2) {
            //Pendiente realizar acciones para inventario por promedio
        }
        
        
        if($programa) {
            $qb->andWhere('sls.programa = :programa')
                ->setParameter('programa', $programa);
        }
        
        if($fInicial) {
            $qb->andWhere('sls.fecha > :fInicial')
                ->setParameter('fInicial', $fInicial);
        }
        
        if($fFinal) {
            $qb->andWhere('ets.fecha < :fFinal')
                ->setParameter('fFinal', $fFinal);
        }
        
        return $qb->getQuery()->getArrayResult();
    }
    
    
}
