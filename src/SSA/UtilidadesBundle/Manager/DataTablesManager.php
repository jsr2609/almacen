<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SSA\UtilidadesBundle\Manager;

use Doctrine\ORM\QueryBuilder;

/**
 * Description of DataTables
 *
 * @author jsr
 */
class DataTablesManager 
{
           
    private $doctrine;
    private $repository;
    private $columns;
    private $extraColumns;
    private $extraColumnsDB;
    private $request;
    private $root;
    private $formNameFilter;
    private $filtersColumns;
    private $applyFiltersForm;

    /**
     * Inicia los parámetros para el datatable
     * 
     * @param string $repository El nombre del repositorio
     * @param mxed $request Los parámetros enviados por el DataTables
     * @param mixed $columns El array de columnas para el DataTable
     * @param mixed $extraColumnsDB Columnas extras para seleccionar de la tabla
     * @param mixed $extraColumns El array de columnas extras para el DataTable
     * @param string $formNameFilter El nombre del formulario de los filtros
     * @param mixed $filtersColumns El arreglo de columnas para los filtros
     * @param boolean $applyFiltersForm Indica si se aplican los filtros del formulario
     * @param string $root EL alias para la consulta
     */
    public function init( $repository, $request, $columns, $extraColumnsDB = array('id'), $extraColumns = null, 
        $formNameFilter = null, $filtersColumns = null, $applyFiltersForm = false,  $root = "j"
    ) {
        $this->columns = $columns; 
        $this->extraColumns = $extraColumns;
        $this->extraColumnsDB = $extraColumnsDB;
        $this->request = $request;        
        $this->repository = $repository;
        $this->root = $root;
        $this->filtersColumns = $filtersColumns;
        $this->formNameFilter = $formNameFilter;
        $this->applyFiltersForm = $applyFiltersForm;
    }
    
    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }
    
    /**
     * Regresa los campos para la setencia SELECT
     * 
     * @return string
     */
    public function getBaseSelect()
    {
        $dbColumns = $this->getDbColumns();
        
        $select = implode(", ", $this->addAliasDbColumns($dbColumns));
        
        return $select;
    }
    
    /**
     * Regresa el QueryBuilder base
     * 
     * @param strins $select Cadena para la setencia SELECT
     * @return QueryBuilder
     */
    public function getBaseQB($select = null) 
    {
        $em = $this->doctrine->getManager();
         
         
        $qb = $em->getRepository($this->repository)->createQueryBuilder($this->root);
        if($select) {
            $qb->select($select);
        } else {
            
            $qb->select($this->getBaseSelect());
        }
        
        return $qb;
        
    }
    
    /**
     * Aplica los filtros y el orden para el DataTable
     * 
     * @return QueryBuilder
     */
    public function applyActionsQB($select = NULL) 
    {
        $qb = $this->getBaseQB($select);
         
        $this->setFiltersQB($qb);
        $this->setOrderQB($qb);
        
        return $qb;
    }
    
    /**
     * Aplica los filtros al objeto QueryBuilder
     * 
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    
    public function setFiltersQB(QueryBuilder $qb) {
        $dtColumns = $this->pluck($this->columns, "dt");  
        //Global Filter
        if(isset($this->request['search']) && $this->request['search']['value'] != '') {
            $str = $this->request['search']['value'];
            for($i = 0, $ien = count($dtColumns); $i < $ien; $i++) {
                $requestColumn = $this->request['columns'][$i];
                $columnIdx = array_search( $requestColumn['data'], $dtColumns );
                $column = $this->columns[ $columnIdx ];
                
                if ( $requestColumn['searchable'] == 'true' ) {
                    
                    $qb->orWhere($qb->expr()->orX($qb->expr()->like($this->root.".".$column['db'], ":str")));                    
                }
            }
            
            $qb->setParameter("str", "%".$str."%");
        }
        
        //Individual column filtering
        for($i = 0, $ien = count($dtColumns); $i < $ien; $i++) {
            $requestColumn = $this->request['columns'][$i];
            $columnIdx = array_search( $requestColumn['data'], $dtColumns );
            $column = $this->columns[ $columnIdx ];

            $str = $requestColumn['search']['value'];
            if ( $requestColumn['searchable'] == 'true' && $str != '' ) {
                $qb->andWhere($qb->expr()->like($this->root.".".$column['db'], ":str".$i));
                $qb->setParameter("str".$i, "%".$str."%");
            }
        }
        
        $this->addFiltersForm($qb);
        
        return $qb;//put your code here
       
    }
    
    /**
     * Agrega los filtros del formulario al QueryBuilder
     * 
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function addFiltersForm(QueryBuilder $qb) {
        if($this->applyFiltersForm) {
            if($this->formNameFilter && isset($this->request['formFilter'])) {
                $formFilter = $this->request['formFilter'][$this->formNameFilter];
                foreach($this->filtersColumns as $index => $column) {
                    if(isset($formFilter[$column['db']]) && $formFilter[$column['db']] != '') {
                        switch($column["type"]) {
                            case "integer":
                                $qb->andWhere($qb->expr()->eq($this->root.".".$column["db"], ":strFF".$index));
                                $qb->setParameter("strFF".$index, $formFilter[$column['db']]);
                                break;
                            default:
                                $qb->andWhere($qb->expr()->like($this->root.".".$column["db"], ":strFF".$index));
                                $qb->setParameter("strFF".$index, "%".$formFilter[$column['db']]."%");
                        }

                    }
                }
            }
        }
        
        return $qb;
    }
    
    
    /**
     * Agrega el orden al QueryBuilder
     * 
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function setOrderQB(QueryBuilder $qb)
    {
        if(isset($this->request['order']) && count($this->request['order']))
        {
            $dtColumns = $this->pluck($this->columns, "dt");
            for ( $i=0, $ien=count($this->request['order']) ; $i<$ien ; $i++ ) {
                $columnIdx = intval($this->request['order'][$i]['column']);
                $requestColumn = $this->request['columns'][$columnIdx];
                $columnIdx = array_search( $requestColumn['data'], $dtColumns );
                $column = $this->columns[ $columnIdx ];
                if ( $requestColumn['orderable'] == 'true' ) {
                    $qb->addOrderBy($this->root.".".$column['db'], $this->request['order'][$i]['dir']);                    
                }
            }
            
        }
        
        return $qb;
    }
    
    /**
     * Agrega el límite de registro al QueryBuilder
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function setLimitQB(QueryBuilder $qb)
    {
        if ( isset($this->request['start']) && $this->request['length'] != -1 ) {
            $qb->setMaxResults($this->request['length']);
            $qb->setFirstResult($this->request['start']);            
        }
        
        return $qb;
    }
    
    /**
     * Regresa las columnas de la base de datos en un arreglo
     * 
     * @return mixed
     */
    public function getDbColumns() {
        $columns = array_merge($this->extraColumnsDB, $this->pluck($this->extraColumns, 'db'), $this->pluck($this->columns, "db"));
        
        return $columns;
               
    }
    
    /**
     * Agrega el alias a las columnas de base de datos
     * 
     * @param string $columns
     * @return string
     */
    public function addAliasDbColumns($columns) {
        $collection = array();
        foreach($columns as $column) {
            $collection[] = $this->root.".".$column;
        }
        
        return $collection;
    }  
    
    /**
     *s
     * @param type $a
     * @param type $prop
     * @return mixed
     */
    public function pluck ( $a, $prop)
    {
        $out = array();

        for ( $i=0, $len=count($a) ; $i<$len ; $i++ ) {
            $out[] = $a[$i][$prop];
        }

        return $out;
    }
    
    /**
     * Regresa las columnas de la petición envíadas del DataTable
     * 
     * @return mixed
     */
    public function getColumnsRequest()
    {
        return $this->request['columns'];
    }
    
    /**
     * Regresa el arreglo de columnas extras
     * 
     * @return mixed
     */
    public function getExtraColumns()
    {
        return $this->extraColumns;
    }
}
