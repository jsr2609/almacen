<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaseManager
 *
 * @author jsr by DTD
 */

namespace AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ORM\Repository;
use Doctrine\ORM\QueryBuilder;
use AppBundle\Entity\Salidas;
use AppBundle\Repository\SalidasRepository;
use SSA\UtilidadesBundle\Manager\DataTablesManager;
use SSA\UtilidadesBundle\Manager\BaseManager;
use SSA\UtilidadesBundle\Helper\Helpers;
use AppBundle\PDF\BaseSalidaPDF;
use AppBundle\PDF\BajaTCPDF;
use AppBundle\PDF\Baja;



class SalidasManager 
{
    private $base; 
    private $repository = "AppBundle:Salidas";
    private $dataTable;
        
    public function __construct(BaseManager $base)
    {
        $this->base = $base;
    }
    
    public function generarFolio( )
    {
        $this->getRepository();
    }
    
    public function setDataTable(DataTablesManager $dt)
    {
        $this->dataTable = $dt;
    }
    
    /**
     * 
     * @param type $repository
     * @return SalidasRepository
     */
    private function getRepository($repository =  null)
    {
        if($repository === null) {
            $repository = $this->repository;
        }
        
        return $this->base->getRepository($repository);
    }
    
    public function comprobarEdicion(Salidas $salida)
    {
        $editable = true;
        $mensaje = ""; 
            $repository = $this->getRepository();
        
            $cantidad = $repository->contarEnSalidas($salida->getId());
            
            if($cantidad > 0) {
                $editable = false;
                $mensaje = "No es posible la edición. Consulte a su Administrador"; 
            }
        
        return array(
            'editable' => $editable,
            'mensaje'  => $mensaje,
        );
    }
    
    /**
     * Inicio de funciones para recuperar registros del datatable
     */
    
    public function obtenerRegistrosDT($ejercicioId, DataTablesManager $dt, $repositorio, $peticion, 
        $columnas, $cExtra = array(), $nombreFF = null, $cFiltros = null
    ) {
        
        $this->dataTable = $dt;
        
        $this->dataTable->init($repositorio, $peticion, $columnas, array('id'));
        
        $registrosTotal = $this->contarRegistrosTotalDT($ejercicioId);
        
        $informacionRegistrosFiltrados = $this->recuperarInformacionFiltrosDT($ejercicioId);
        
        return array(
            "draw" => \intval($peticion['draw']),
            "recordsTotal"    => intval( $registrosTotal ),
            "recordsFiltered" => intval( $informacionRegistrosFiltrados['total'] ),
            "data"            =>  $this->dataOutputDT($columnas, $informacionRegistrosFiltrados['registros'], $cExtra)
        );
    }
    
    public function dataOutputDT($columns, $records, $extraColums = null) {
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
            /*
            $configuracion = "<a data-toggle='tooltip' title='Configuración' class='btn btn-primary btn-xs' href='".
                    $this->base->generateUrl('admin_avales_configuracion', array('id' => $record['id'])).
                    "'><i class='fa fa-cog fa-fw'></i></a>";
             
             */
            $editar = '<a class="btn btn-primary btn-xs" href="'.
                    $this->base->generateUrl('admin_salidas_edit', array('id' => $record['id'])).
                    '"><i class="fa fa-edit fa-fw"></i> Editar</a>';
            if($record['tipoCompra'] == 1){
            $articulos = '<a class="btn btn-default btn-xs" href="'.
                    $this->base->generateUrl('admin_salidadetallesDirecta', array('id' => $record['id'])).
                    '"><i class="fa fa-list fa-fw"></i> Articulos</a>';
            }else{
                $articulos = '<a class="btn btn-default btn-xs" href="'.
                    $this->base->generateUrl('admin_salidadetalles', array('id' => $record['id'])).
                    '"><i class="fa fa-list fa-fw"></i> Articulos</a>';
            }
            $row[] = $editar.' '.$articulos;
            

            $out[] = $row;
           
        }
        
        return $out;
    }
    
    public function agregarFiltrosExtraQBDT(QueryBuilder $qb, $ejercicioId, $activo = true) 
    {      
        $root = $qb->getRootAliases()[0];
        
        $qb->andWhere($root.".activo = :activo");        
        $qb->setParameter("activo", $activo);
        
        $qb->andWhere($root.".ejercicio = :ejercicio");        
        $qb->setParameter("ejercicio", $ejercicioId);
        
        return $qb;
        
        
    }
    
    public function contarRegistrosTotalDT($ejercicioId, $activo = true) {
        
        $qb = $this->dataTable->getBaseQB();
        $root = $qb->getRootAliases()[0];
        
        $this->agregarFiltrosExtraQBDT($qb, $ejercicioId, $activo);
        
        $qb->select($qb->expr()->count($root));  
        return $qb->getQuery()->getSingleScalarResult();
    }
    
    public function recuperarInformacionFiltrosDT($ejercicioId, $activo = true) 
    {
       $qb = $this->dataTable->getBaseQB(null);
        $this->dataTable->setFiltersQB($qb);
        
        $root = $qb->getRootAliases()[0];
        $this->agregarFiltrosExtraQBDT($qb, $ejercicioId, $activo); 
        //Agregar Filtros extra si se necesitan
        $total = $qb->select($qb->expr()->count($root))->getQuery()->getSingleScalarResult();  
        
        $this->dataTable->setOrderQB($qb);
        $this->dataTable->setLimitQB($qb);
        
        $qb->select($this->dataTable->getBaseSelect());
        $registros = $qb->getQuery()->getArrayResult();
        
        return array(
            'total' => $total,
            'registros' => $registros,
        );
    }
    
    public function buscar($id, $select = null, $devolverNull = false, $hydrationMode = 'HYDRATE_OBJECT')
    {
        $repository = $this->getRepository();
        $entidad = $repository->buscar($id, $select, $hydrationMode);
        
        if(!$devolverNull && !$entidad ) {
            
            throw $this->base->createNotFoundException("No se encontró una salida con el id ".$id);
        }
        
        return $entidad;
    }
    
    public function generarPDF(BajaTCPDF $pdf, $salida)
    {        
        
        $footerText = array(
            'address' => $salida['ejercicio']['almacen']['domicilio'],
            'telephones' => $salida['ejercicio']['almacen']['telefonos'],
        );
        
        die(var_dump($footerText));
        
        $pdf->init($salida, $footerText);
        $sdsRepository = $this->base->getRepository('AppBundle:SalidaDetalles');
        $baja = new Baja($pdf, $salida);
        
        $baja->imprimirDetalles($sdsRepository);
        
        $baja->imprimirFirmasdeSalida();
        
        
        return $pdf;
    }
    
}