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

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ORM\Repository;
use Doctrine\ORM\QueryBuilder;
use AppBundle\Entity\Entradas;
use AppBundle\Repository\EntradasRepository;
use SSA\UtilidadesBundle\Manager\DataTablesManager;
use SSA\UtilidadesBundle\Manager\BaseManager;
use SSA\UtilidadesBundle\Helper\Helpers;
use AppBundle\PDF\BasePDF;
use AppBundle\PDF\AltasTCPDF;
use AppBundle\PDF\Alta;



class EntradasManager 
{
    private $base; 
    private $repository = "AppBundle:Entradas";
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
     * @return EntradasRepository
     */
    private function getRepository($repository =  null)
    {
        if($repository === null) {
            $repository = $this->repository;
        }
        
        return $this->base->getRepository($repository);
    }
    
    public function comprobarEdicion(Entradas $entrada)
    {
        $editable = true;
        $mensaje = ""; 
        
        if($entrada->getValidada()) {
            $editable = false;
            $mensaje = "La entrada ya fue validada, no es posible la edición.";
        } else {
            $repository = $this->getRepository();
        
            $cantidad = $repository->contarEnSalidas($entrada->getId());
            if($cantidad > 0) {
                $editable = false;
                $mensaje = "Ya existen salidas de esta entrada, no es posible la edición.";
            }
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
            if(!$record['facturaNumero']) {
                $row["DT_RowClass"] = "warning text-warning";    
            }
            
            /*
            $configuracion = "<a data-toggle='tooltip' title='Configuración' class='btn btn-primary btn-xs' href='".
                    $this->base->generateUrl('admin_avales_configuracion', array('id' => $record['id'])).
                    "'><i class='fa fa-cog fa-fw'></i></a>";
             
             */
            $editar = '<a class="btn btn-primary btn-xs" href="'.
                    $this->base->generateUrl('admin_entradas_edit', array('id' => $record['id'])).
                    '"><i class="fa fa-edit fa-fw"></i> Editar</a>';
            $articulos = '<a class="btn btn-default btn-xs" href="'.
                    $this->base->generateUrl('admin_entradadetalles', array('id' => $record['id'])).
                    '"><i class="fa fa-list fa-fw"></i> Articulos</a>';
            $row[] = $editar.' '.$articulos;
            

            $out[] = $row;
           
        }
        
        return $out;
    }
    
    public function agregarFiltrosExtraQBDT(QueryBuilder $qb, $ejercicioId, $activo = true) 
    {      
        $root = $qb->getRootAliases()[0];
        $qb->andWhere($root.".activa = :activo");        
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
            
            throw $this->base->createNotFoundException("No se encontró una entrada con el id ".$id);
        }
        
        return $entidad;
    }
    
    /**
     * Fin de funciones para recuperar registros del datatable
     */
    
    public function generarPDF(AltasTCPDF $pdf, $entrada)
    {   
        $footerText = array(
            'address' => $entrada['ejercicio']['almacen']['domicilio'],
            'telephones' => $entrada['ejercicio']['almacen']['telefonos'],
        );
        
        $pdf->init($entrada, $footerText);
        $edsRepository = $this->base->getRepository('AppBundle:EntradaDetalles');
        $alta = new Alta($pdf, $entrada);
        
        $alta->imprimirDetalles($edsRepository);
        
        $alta->imprimirFirmas();
        
        
        return $pdf;
    }
    
    public function procesarDePedido($datospedido, $proveedor, $programa, $ejercicio) {
        $entrada = new Entradas();
        $entrada->setFecha(new \DateTime());
        $entrada->setPedidoNumero($datospedido['pedidonumero']);
        $compra = $datospedido['compra'];
        
        $indiceCompra = array_search($compra, Entradas::$pedidoTiposAdquisiciones);
        if(!$indiceCompra)
        {
            throw new \LogicException("No existe un valor $compra en pedidoTiposAdquisiciones de Entradas");
        }        
        $entrada->setCompra($indiceCompra);
        $entrada->setAnioEjercicio($datospedido['ejercicio']);
        $entrada->setProveedor($proveedor);
        $entrada->setPrograma($programa);
        $entrada->setEjercicio($ejercicio);
        $tipoCompra = $datospedido['tipocompra'];
        
        $indiceTipoCompra = array_search($tipoCompra, Entradas::$pedidoTiposCompra);
        if(!$indiceTipoCompra)
        {
            throw new \LogicException("No existe un valor $tipoCompra en pedidoTiposCompra de Entradas");
        }    
        
        $entrada->setTipoCompra($indiceTipoCompra);
        
        return $entrada;
        
    }
    
    /**
     * Verifica si una de las partidas tiene fecha de caducidad
     * @param array $partidas
     * @param ParametrosManager $parameterManager
     */
    public function verificarPartidasConCaducidad($partidas, $parameterManager = null)
    {
        $partidasConCaducidad = array('25301');
        $conCaducidad = false;
        foreach($partidas as $partida) {
            if(array_search($partida['clave'], $partidasConCaducidad) !== false) {
                $conCaducidad = true;
                break;
                
            }
        }
        
        return $conCaducidad;
    }
    
}