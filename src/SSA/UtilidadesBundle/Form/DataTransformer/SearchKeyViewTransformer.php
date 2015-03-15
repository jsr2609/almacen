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

class SearchKeyViewTransformer implements DataTransformerInterface
{
    public function __construct()
    {
        
    }
    
    /**
     * Transforma un valor escalar en un objeto
     * 
     * @param type $value
     * @return \AppBundle\Entity\Programas
     */
    
    public function reverseTransform($value) 
    {
        die("rtvw");
        
    }

    /**
     * Transforma un objeto en un valor scalar
     * 
     * @param type $value
     * @return string
     */
    public function transform($value) 
    {
        die("tvw");
    }

//put your code here
}
