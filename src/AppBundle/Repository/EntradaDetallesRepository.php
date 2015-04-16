<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class EntradaDetallesRepository extends EntityRepository
{
    private $rootAlias = 'eds';
    
    public function buscarTodos($entradaId = null, $select = null, $hydrationMode = 'HYDRATE_ARRAY')
    {
        if(!$select) {
            $select = 'eds, eta, art';            
        }
        $qb = $this->createQueryBuilder('eds');
        $qb->select($select);
        $qb->innerJoin('eds.entrada', 'eta')
            ->innerJoin('eds.articulo', 'art');
        if($entradaId) {
            $qb->andWhere('eds.entrada = :entrada');
            $qb->setParameter('entrada', $entradaId);
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
        $dql = "SELECT DISTINCT(pts.id), pts.clave, pts.nombre FROM AppBundle:EntradaDetalles eds "
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
}
