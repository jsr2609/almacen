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
    
    public function obtenerPedido($numeroPedido, $compra, $ejercicio) 
    {
        $conn = $this->getDoctrine()->getConnection('adquisiciones');
        //die(var_export($conn->getParams()));
        //die(var_export(get_class_methods(get_class($conn))));
        //Recuperar el pedido
        $sqlp = "SELECT * FROM tblpedi AS pds WHERE pds.no_pedido LIKE '234' AND pds.compra LIKE '25' "
                . "AND pds.ejercicio = 2015;";
        $p1 = $conn->fetchAssoc($sqlp);
        
        //die(var_export(get_class_methods(get_class($conn))));
        die(var_export($p1));
        
        //Recuperar detalles
        
        //die(var_export(get_class_methods(get_class($conn))));
        $sql = "SELECT dps.cve_articulo AS Clave, ats.descripcion AS Nombre, dps.cantidad as Cantidad, "
                . "dps.precio as Precio  "
                . "from tbldetpe AS dps "
                . "INNER JOIN tblpedi pds ON (dps.no_pedido = pds.no_pedido and dps.compra = pds.compra and dps.ejercicio = pds.ejercicio) "
                . "INNER JOIN tblartic ats ON (dps.cve_articulo = ats.cve_articulo)";
        $p = $conn->fetchAll($sql);
        die(var_export($p));
        die(var_export("Creara de pedido"));
    }
    
}