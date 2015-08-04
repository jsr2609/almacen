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
    
    public function obtenerPedido($pedidoNumero, $compra, $anioEjercicio) 
    {
        $conn = $this->doctrine->getConnection('adquisiciones');
        //die(var_export($conn->getParams()));
        //die(var_export(get_class_methods(get_class($conn))));
        //Recuperar el pedido
        $sql = "SELECT pds.no_pedido AS PedidoNumero, pds.compra as Compra, pds.ejercicio as Ejercicio, pds.fecha_pedido as PedidoFecha, "
                . "pds.cve_provedor AS ProveedorClave, pds.razon_social as ProveedorNombre, pds.cve_depto AS DepartamentoClave, "
                . "pds.programa AS ProgramaClave, pds.descripcion_programa as ProgramaNombre, "
                . "pds.tipo_compra as TipoCompra, pds.Destino as Destino "
                . "FROM qry_datosgrales_pedidos AS pds "
                . "WHERE pds.no_pedido LIKE :pedidoNumero "
                . "AND pds.compra LIKE :compra "
                . "AND pds.ejercicio = :ejercicio"
        ;
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue('pedidoNumero', $pedidoNumero);
        $stmt->bindValue('compra', $compra);
        $stmt->bindValue('ejercicio', $anioEjercicio);
        
        $stmt->execute();
        
        //$articulos = $stmt->fetchAll();
        $pedido = $stmt->fetch();
        
        return $pedido;
    }
    
    public function obtenerArticulosPedido($pedidoNumero, $compra, $anioEjercicio)
    {
        $conn = $this->doctrine->getConnection('adquisiciones');
        $sql = "SELECT dps.no_pedido AS PedidoNumero, dps.compra as Compra, dps.ejercicio as Ejercicio, "
                . "dps.partida as PartidaClave, dps.descripcion_partida as PartidaNombre, dps.cve_articulo as Clave, "
                . "dps.descripcion_articulo AS nombre, dps.unidad as Unidad, dps.iva as IVA, dps.Cantidad as Cantidad, "
                . "dps.Precio as Precio, dps.subtotal as Subtotal, dps.marcas as Marcas, dps.anexo as Anexo "
                . "FROM qry_detalles_pedidos AS dps "
                . "WHERE dps.no_pedido LIKE :pedidoNumero "
                . "AND dps.compra LIKE :compra "
                . "AND dps.ejercicio = :ejercicio "
        ;
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue('pedidoNumero', $pedidoNumero);
        $stmt->bindValue('compra', $compra);
        $stmt->bindValue('ejercicio', $anioEjercicio);
        $stmt->execute();
        
        
        $articulos = $stmt->fetchAll();
        
        return $articulos;
    }
    
}