<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SSA\UtilidadesBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of SearchKeyTransformer
 *
 * @author jsr
 */

class SearchKeyTransformer implements DataTransformerInterface
{
    public function __construct()
    {
        
    }
    
    public function reverseTransform($value) 
    {
        die("REVERDE");
    }

    public function transform($value) 
    {
        return "HOLA";
    }

//put your code here
}
