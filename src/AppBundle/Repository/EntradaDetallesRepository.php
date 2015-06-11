<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class EntradaDetallesRepository extends EntityRepository
{
    private $rootAlias = 'eds';
    
    public function buscarTodos($select = null, $entradaId = null, $partidaId = null, $hydrationMode = 'HYDRATE_ARRAY')
    {
        if(!$select) {
            $select = 'eds, ets, ats';
        }
        $qb = $this->createQueryBuilder('eds');
        $qb->select($select);
        $qb->innerJoin('eds.entrada', 'ets')
            ->innerJoin('eds.articulo', 'ats')
            ->innerJoin('ats.partida', 'pts')
            ->innerJoin('ats.presentacion', 'pss')
        ;
        if($entradaId) {
            $qb->andWhere('eds.entrada = :entrada');
            $qb->setParameter('entrada', $entradaId);
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
    
    public function obtenerPartidasPorEntrada($entradaId) 
    {
        $dql = "SELECT DISTINCT pts.id, pts.clave, pts.nombre FROM AppBundle:EntradaDetalles eds "
                . "INNER JOIN eds.entrada AS ets "
                . "INNER JOIN eds.articulo AS ats "
                . "INNER JOIN ats.partida AS pts "
                . "WHERE ets.id = :entrada";
        $query = $this->getEntityManager()->createQuery($dql);
        
        $query->setParameter('entrada', $entradaId);
        
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
    
    public function contarEnSalidas($entradaDetalleId)
    {
        $dql = "SELECT COUNT(sds) FROM AppBundle:SalidaDetalles sds "
                . "INNER JOIN sds.entradaDetalle eds "
                . "WHERE eds.id = :entradaDetalle";
        
        $query = $this->getEntityManager()->createQuery($dql)
                ->setParameter('entradaDetalle', $entradaDetalleId);
        
        return $query->getSingleScalarResult();
    }
    
    public function buscarPorArticulo($articulo, $select = null, $programa = null, $fInicial = null, $fFinal = null)
    {
        $qb = $this->createQueryBuilder('eds');        
        $qb->innerJoin('eds.entrada', 'ets');        
        $select = ($select === null) ? 'eds, ets' : $select;
        $qb->select($select)
            ->andWhere('eds.articulo = :articulo')
            ->setParameter('articulo', $articulo)
        ;
        
        if($programa) {
            $qb->andWhere('eds.programa = :programa')
                ->setParameter('programa', $programa);
        }
        
        if($fInicial) {
            $qb->andWhere('ets.fecha > :fInicial')
                ->setParameter('fInicial', $fInicial);
        }
        
        if($fInicial) {
            $qb->andWhere('ets.fecha < :fInicial')
                ->setParameter('fInicial', $fInicial);
        }
        
        if($fFinal) {
            $qb->andWhere('ets.fecha > :fFinal')
                ->setParameter('fFinal', $fFinal);
        }
        
        return $qb->getQuery()->getArrayResult();
    }
}
