<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SSA\UtilidadesBundle\Helper;

/**
 * Description of Helpers
 *
 * @author jsr
 */
class Helpers 
{
    public static function getSubString($string, $length=NULL)
    {
        //Si no se especifica la longitud por defecto es 50
        if ($length == NULL)
            $length = 100;
        //Primero eliminamos las etiquetas html y luego cortamos el string
        $stringDisplay = substr(strip_tags($string), 0, $length);
        //Si el texto es mayor que la longitud se agrega puntos suspensivos
        if (strlen(strip_tags($string)) > $length)
            $stringDisplay .= ' ...';
        return $stringDisplay;
    }
}
