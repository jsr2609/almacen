<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaseManager
 *
 * @author jsr
 */

namespace AppBundle\Manager;

use SSA\UtilidadesBundle\Manager\BaseManager;
use SSA\UtilidadesBundle\Manager\DataTablesManager;
use Doctrine\ORM\QueryBuilder;
use AppBundle\Repository\ArticulosRepository;
use AppBundle\Entity\Articulos;



class ArticulosManager 
{
    private $repository = "AppBundle:Articulos";
    private $dataTable;
    private $base;
        
    public function __construct(BaseManager $base)
    {
        $this->base = $base;
    }
    
    public function buscar($valor, $select = null, $campo = null, 
        $hydrationMode = null, $acceptNull = false) 
    {        
        $hydrationMode =  ($hydrationMode == null) ? 'HYDRATE_OBJECT' : $hydrationMode;
        $campo = ($campo == null) ? 'clave' : $campo;
        
        $repository = $this->getRepository();
        $articulo = $repository->buscar($valor, $select, $campo, $hydrationMode);
        
        if(!$articulo && !$acceptNull) {
            throw $this->base->createNotFoundException("No se encontró un articulo con el valor $valor");
        }
        
        return $articulo;
    }
    
    //Inician funciones DataTables
    public function obtenerRegistrosDT(DataTablesManager $dt, $repositorio, $peticion, 
        $columnas, $cExtra = array(), $nombreFF = null, $cFiltros = null, $fnEnlaces = null) 
       {
        
        $activo = true;
        $this->dataTable = $dt;
        $this->dataTable->init($repositorio, $peticion, $columnas, array('id')); 
        
        if($peticion['programa'] == null){
            $registrosTotal = $this->contarRegistrosTotalDT($activo);
        }else{
            $registrosTotal = $this->contarRegistrosTotalDT($activo ,$peticion['programa']);
        }
        
        $informacionRegistrosFiltrados = $this->recuperarInformacionFiltrosDT($activo ,$peticion['programa']);
        
        return array(
            "draw" => \intval($peticion['draw']),
            "recordsTotal"    => intval( $registrosTotal ),
            "recordsFiltered" => intval( $informacionRegistrosFiltrados['total'] ),
            "data"            =>  $this->dataOutputDT($columnas, $informacionRegistrosFiltrados['registros'], $cExtra, $fnEnlaces)
        );
    }
    
    
    
    public function agregarFiltrosExtraQBDT(QueryBuilder $qb, $root, $activo, $programa) 
    {      
        
        
        if($programa == null){
            $qb->andWhere($root.".activo = :activo");        
            $qb->setParameter("activo", $activo);
        }else{
            $qb->andWhere($root.".programaId = :programa");
            $qb->andWhere($root.".tipoEntrada != 1");
            $qb->andWhere($root.".existencia > 0");
            $qb->setParameter("programa", $programa);
        }
        
        return $qb;
    }
    
    
    public function contarRegistrosTotalDT($activo = true, $programa = null) {
        
        $qb = $this->dataTable->getBaseQB();
        $root = $qb->getRootAliases()[0];
        
        
         $this->agregarFiltrosExtraQBDT($qb, $root, $activo, $programa);
        
        
        $qb->select($qb->expr()->count($root));  
        return $qb->getQuery()->getSingleScalarResult();
    }
    
    public function recuperarInformacionFiltrosDT($activo = true, $programa) 
    {
        $qb = $this->dataTable->applyActionsQB();
        $root = $qb->getRootAliases()[0];
        $this->agregarFiltrosExtraQBDT($qb, $root, $activo, $programa); 
        //Agregar Filtros extra si se necesitan    
        
        $total = $qb->select($qb->expr()->count($root))->getQuery()->getSingleScalarResult();  
        
        $this->dataTable->setLimitQB($qb);
        
        $qb->select($this->dataTable->getBaseSelect());
        $registros = $qb->getQuery()->getArrayResult();
        
        return array(
            'total' => $total,
            'registros' => $registros,
        );
    }
    
    public function dataOutputDT($columns, $records, $extraColums = null, $fnEnlaces = null) {
        if(!$fnEnlaces) {
            $fnEnlaces = "enlacesIndex";
        }
        $out = array();
        $basePath = $this->base->getBasePath();
        foreach($records as $indexRow => $record) {
            $row = array();
            for ( $j=0, $jen=count($columns) ; $j<$jen ; $j++ ) {
                $column = $columns[$j];

                // Is there a formatter?
                if ( isset( $column['formatter'] ) ) {
                    $row[ $column['dt'] ] = $column['formatter']( $record[ $column['db'] ], $record );
                }
                else {
                    $row[ $column['dt'] ] = $record[ $columns[$j]['db'] ];
                }
            }    
           
            $enlaces = call_user_func(array($this, $fnEnlaces), $record);
            
            $row[] = $enlaces;
            

            $out[] = $row;
           
        }
        
        return $out;
    }
    
    //Fin funciones dataTables
    
    public function enlacesIndex($record)
    {
        
        $editar = '<a data-toggle="tooltip" title="Editar" class="btn btn-primary btn-xs" href="'.
                    $this->base->generateUrl('admin_articulos_edit', array('id' => $record['id'])).
                    '"><i class="fa fa-edit fa-fw"></i> </a>';
        $consultar = '<a data-toggle="tooltip" title="Consultar" class="btn btn-default btn-xs" href="'.
                $this->base->generateUrl('admin_articulos_show', array('id' => $record['id'])).
                '"><i class="fa fa-search fa-fw"></i> </a>';

        $enlaces =  $editar." ".$consultar;
        
        return $enlaces;
    }
    
    public function enlacesPopupIndex($record)
    {
        
        $editar = '<button data-toggle="tooltip" title="Editar" class="btn btn-primary btn-xs btn-seleccionar" articulo-clave="'.$record['clave'].'" ><i class="fa fa-check-circle fa-fw"></i> </button>';
        

        $enlaces =  $editar;
        
        return $enlaces;
    }
    
    /**
     * 
     * @return ArticulosRepository
     */
    public function getRepository()
    {
        return $repository = $this->base->getRepository($this->repository);
    }
    
    public function comprobarExistencias($articulos, $campo = 'clave')
    {
        $repository = $this->getRepository();
        $em = $this->base->getManager();
        
        foreach($articulos as $articulo) {
            $articuloObj = $repository->findOneBy(array(
                $campo => $articulo['clave'],
            ));
            if(!$articuloObj) {
                $articuloObj = new Articulos();
                $articuloObj->setClave($articulo['clave']); 
                $articuloObj->setNombre($articulo['nombre']);
                $articuloObj->setNombre($articulo['nombre']);
                $articuloObj->setPresentacion($em->getReference("AppBundle:Presentaciones", 1));
                $articuloObj->setPartida($em->getReference("AppBundle:Partidas", 16));
                $articuloObj->setPartidaClave($articulo['partida']);
                $em->persist($articuloObj);
                
            }
        }
        
        $em->flush();
    }
    
    
    
}