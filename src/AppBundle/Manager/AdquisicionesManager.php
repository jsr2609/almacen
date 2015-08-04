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
    
    public function obtenerPedido($pedidoNumero, $compra = null, $anioEjercicio = null) 
    {
        $conn = $this->doctrine->getConnection('adquisiciones');
        //die(var_export($conn->getParams()));
        //die(var_export(get_class_methods(get_class($conn))));
        //Recuperar el pedido
        $sql = "SELECT pds.no_pedido AS PedidoNumero, pds.compra as Compra, pds.ejercicio as AnioEjercicio, pds.fecha_pedido as PedidoFecha, "
                . "pds.cve_provedor AS ProveedorClave, pds.cve_depto AS DepartamentoClave, pds.fecha_entrega as FechaEntrega, "
                . "pds.cve_presup AS ProgramaClave, pds.descripcion_programa as ProgramaNombre, pds.no_sol_compra AS NumeroSolicitudCompra, "
                . "pds.tipo_compra as TipoCompra, pds.Destino as Destino "
                . "FROM qry_datosgrales_pedidos AS pds "
                . "WHERE pds.no_pedido LIKE ':pedidoNumero' "
                . "AND WHERE pds.compra LIKE ':compra' "
                . "AND WHERE pds.ejercicio = :ejercicio"
        ;
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue('pedidoNumero', $pedidoNumero);
        $stmt->bindValue('compra', $compra);
        $stmt->bindValue('ejercicio', $anioEjercicio);
        
        $stmt->execute();
        
        //$articulos = $stmt->fetchAll();
        $pedido = $stmt->fetch();
        die(var_export($pedido));
        return $pedido;
    }
    
    public function obtenerArticulosPedido($pedidoNumero)
    {
        $conn = $this->doctrine->getConnection('adquisiciones');
        $sql = "SELECT dps.cve_articulo AS Clave, ats.descripcion AS Nombre, ats.partida AS Partida, dps.cantidad as Cantidad, "
                . "dps.precio as Precio  "
                . "from tbldetpe AS dps "
                . "INNER JOIN tblpedi pds ON (dps.no_pedido = pds.no_pedido) "
                . "INNER JOIN tblartic ats ON (dps.cve_articulo = ats.cve_articulo) "
                . "WHERE dps.no_pedido LIKE :pedidoNumero";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue('pedidoNumero', $pedidoNumero);
        $stmt->execute();
        
        
        $articulos = $stmt->fetchAll();
        
        return $articulos;
    }
    
}