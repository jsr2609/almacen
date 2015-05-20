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
        
        if($entrada->getValidada()) {
            $editable = false;
            $mensaje = "La salida ya fue validada, no es posible la edición.";
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
                    $this->base->generateUrl('admin_salidas_edit', array('id' => $record['id'])).
                    '"><i class="fa fa-edit fa-fw"></i> Editar</a>';
            $articulos = '<a class="btn btn-default btn-xs" href="'.
                    $this->base->generateUrl('admin_salidadetalles', array('id' => $record['id'])).
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
            
            throw $this->base->createNotFoundException("No se encontró una salida con el id ".$id);
        }
        
        return $entidad;
    }
    
    /**
     * Fin de funciones para recuperar registros del datatable
     
    
    public function generarPDF(\TCPDF $pdf, $entrada)
    {
        
        $pdf->SetHeaderData(PDF_HEADER_LOGO, 50, PDF_HEADER_TITLE, mb_strtoupper($entrada['ejercicio']['almacen']['nombre'], 'UTF-8'), array(0,64,255), array(0,64,128));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(10, PDF_MARGIN_TOP, 10);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        
        $pdf->AddPage();
        
        $pdf->Ln(2);
        //$pdf->Cell($w, $h, $txt, $border, $ln, $align, $fill, $link, $stretch, $ignore_min_height)
        $pdf->SetFont('helvetica', 'B', 13);
        $pdf->Cell(0, 0, 'AVISO DE ALTA', '', 1, 'C');
        
        $pdf->SetFont('helvetica', '', 9);
        $pdf->Ln(5);
        $pdf->Cell(0, 0, 'No. '.$entrada['folio'], '', 1, 'R');
        $pdf->Ln(5);
        $lugar = $entrada['ejercicio']['almacen']['lugar']." A ".$entrada['fecha']->format('d/m/Y');
        $pdf->Cell(0, 0, $lugar, '', 1, 'L');
        $pdf->Cell(0, 0, mb_strtoupper($entrada['ejercicio']['almacen']['nombreJefeServicios']), '', 1, 'L');
        $pdf->Cell(0, 0, 'CON ESTA FECHA SE DAN DE ALTA PROCEDENTES DE:', '', 1, 'L');
        $pdf->Cell(0, 0, mb_strtoupper($entrada['proveedor']['nombre']), '', 1, 'L');
        
        $datosFactura = 'SEGUN FACTURA '.$entrada['facturaNumero'].', DE FECHA '.$entrada['facturaFecha']->format('d/m/Y')
            .', NÚMERO DE PEDIDO '.$entrada['pedidoNumero'];
        $pdf->Cell(0, 0, $datosFactura, '', 1, 'L');
        $programa = $entrada['programa']['clave'].'-'.$entrada['programa']['nombre'];
        $pdf->Cell(0, 0, 'PROGRAMA: '.$programa, '', 1, 'L');
        $pdf->Cell(0, 0, 'OBSERVACIONES: '.mb_strtoupper($entrada['observaciones']), '', 1, 'L');
        $pdf->Cell(0, 0, 'LOS ARTICULOS QUE ACONTINUACIÓN SE DETALLAN:', '', 1, 'L');
        $pdf->Ln(5);
        $pdf->SetFont('helvetica', '', 8);
        
        $wPage = $pdf->getPageWidth() - PDF_MARGIN_LEFT - PDF_MARGIN_RIGHT;
        $wCve = 20;
        $wNombre = 80;
        $wCaducidad = 15;
        $wCantidad = 15;
        $wUnidad = 20;
        $wPrecio = 20;
        $wImporte = 20;
        $hCell = 5;
        
        
        
        $pdf->cell($wCve, $hCell, 'CLAVE', 'LTRB', 0, 'C');
        $pdf->cell($wNombre, $hCell, 'NOMBRE', 'LTRB', 0, 'C');
        $pdf->cell($wCaducidad, $hCell, 'CAD.', 'LTRB', 0, 'C');
        $pdf->cell($wCantidad, $hCell, 'CANTIDAD', 'LTRB', 0, 'C');
        $pdf->cell($wUnidad, $hCell, 'UNIDAD', 'LTRB', 0, 'C');
        $pdf->cell($wPrecio, $hCell, 'PRECIO', 'LTRB', 0, 'C');
        $pdf->cell($wImporte, $hCell, 'IMPORTE', 'LTRB', 1, 'C');
        
        $pdf->Ln(1);
        
        $pdf->SetFont('helvetica', '', 8);
        
        $edsRepository = $this->base->getRepository('AppBundle:EntradaDetalles');
        $partidas = $edsRepository->obtenerPartidasPorEntrada($entrada['id']);
        
        foreach($partidas as $partida) {
            $pdf->SetFont('helvetica', 'B', 8);
            $pdf->cell($wImporte, $hCell, $partida['nombre'], '', 1, 'l');
            $pdf->Ln(1);
            $pdf->SetFont('helvetica', '', 8);
            //Articulos
            $pdf->cell($wCve, $hCell, '000.211.0056', 'LTRB', 0, 'C');
            $pdf->cell($wNombre, $hCell, 'CONJUNTO SEMIEJECUTIVO LINEA ERGOS', 'LTRB', 0, 'L');
            $pdf->cell($wCaducidad, $hCell, '22/12/2018', 'LTRB', 0, 'C');
            $pdf->cell($wCantidad, $hCell, '1,200,000', 'LTRB', 0, 'R');
            $pdf->cell($wUnidad, $hCell, 'PIEZA', 'LTRB', 0, 'C');
            $pdf->cell($wPrecio, $hCell, '3,400,255.00', 'LTRB', 0, 'R');
            $pdf->cell($wImporte, $hCell, '3,400,255.00', 'LTRB', 1, 'R');
        }
        
        return $pdf;
    }*/
    
}