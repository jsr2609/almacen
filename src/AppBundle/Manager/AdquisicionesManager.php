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
use Doctrine\Bundle\DoctrineBundle\Registry;


class AdquisicionesManager 
{
    private $doctrine;
    
    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    
    public function obtenerPedido($pedidoNumero, $compra = null, $ejercicio = null) 
    {
        $conn = $this->doctrine->getConnection('adquisiciones');
        //die(var_export($conn->getParams()));
        //die(var_export(get_class_methods(get_class($conn))));
        //Recuperar el pedido
        $sql = "SELECT pds.no_pedido AS PedidoNumero, pds.tipo_compra as TipoCompra, pds.ejercicio as Ejercicio, pds.fecha_pedido as PedidoFecha, "
                . "pds.destino as Destino, "
                . "pgs.programa AS ProgramaClave, pgs.descripcio as ProgramaNombre, "
                . "pvs.cve_provedor as ProveedorClave, pvs.razon_social AS ProveedorNombre "               
                . "FROM tblpedi AS pds "
                . "INNER JOIN tblofic AS ofs ON (pds.cve_depto = ofs.cve_depto) "
                . "INNER JOIN tblpresu AS pgs ON (pds.cve_presup = pgs.programa) "
                . "INNER JOIN tblprov AS pvs ON (pds.cve_provedor = pvs.cve_provedor) "
                . "WHERE pds.no_pedido LIKE '$pedidoNumero'"
        ;
        $pedido = $conn->fetchAssoc($sql);
        
        return $pedido;
        
        //Recuperar detalles del pedido
        
        //die(var_export(get_class_methods(get_class($conn))));
        die(var_export($p1));
        
        //Recuperar detalles
        
        //die(var_export(get_class_methods(get_class($conn))));
        
        $p = $conn->fetchAll($sql);
        die(var_export($p));
        die(var_export("Creara de pedido"));
    }
    
    public function obtenerArticulosPedido($pedidoNumero)
    {
        $conn = $this->doctrine->getConnection('adquisiciones');
        $sql = "SELECT dps.cve_articulo AS Clave, ats.descripcion AS Nombre, ats.partida AS Partida, dps.cantidad as Cantidad, "
                . "dps.precio as Precio  "
                . "from tbldetpe AS dps "
                . "INNER JOIN tblpedi pds ON (dps.no_pedido = pds.no_pedido) "
                . "INNER JOIN tblartic ats ON (dps.cve_articulo = ats.cve_articulo) "
                . "WHERE dps.no_pedido like '$pedidoNumero'";
        
        $articulos = $conn->fetchAll($sql);
        
        return $articulos;
    }
    
}