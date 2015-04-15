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
        $qb = $this->dataTable->applyActionsQB();
        $root = $qb->getRootAliases()[0];
        $this->agregarFiltrosExtraQBDT($qb, $ejercicioId, $activo); 
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
    
    public function generarPDF(\TCPDF $pdf, $entrada)
    {
        $pdf->SetHeaderData(PDF_HEADER_LOGO, 50, PDF_HEADER_TITLE, "ALMACEN CENTRAL", array(0,64,255), array(0,64,128));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        
        $pdf->AddPage();
        $pdf->Ln(2);
        //$pdf->Cell($w, $h, $txt, $border, $ln, $align, $fill, $link, $stretch, $ignore_min_height)
        $pdf->SetFont('helvetica', 'B', 13);
        $pdf->Cell(0, 0, 'AVISO DE ALTA', '', 1, 'C');
        
        $pdf->SetFont('helvetica', '', 11);
        $pdf->Ln(5);
        
        $lugar = $entrada['ejercicio']['almacen']['lugar']." A ".$entrada['fecha']->format('d/m/Y');
        $pdf->Cell(0, 0, $lugar, '', 1, 'L');
        $pdf->Cell(0, 0, mb_strtoupper($entrada['ejercicio']['almacen']['nombreJefeServicios']), '', 1, 'L');
        $pdf->Cell(0, 0, 'CON ESTA FECHA SE DAN DE ALTA PROCEDENTES DE', '', 1, 'L');
        $datosFactura = 'SEGUN FACTURA '.$entrada['facturaNumero'].' DE FECHA '.$entrada['facturaFecha']->format('d/m/Y').', NUMERO DE PEDIDO '.$entrada['pedidoNumero'];
        $pdf->Cell(0, 0, $datosFactura, '', 1, 'L');
        
        
        
        
        
        return $pdf;
    }
    
}