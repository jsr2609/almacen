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
use Symfony\Component\PropertyAccess\PropertyAccessor;

/**
 * Description of SearchKeyTransformer
 *
 * @author jsr
 */

class SearchKeyDataTransformer implements DataTransformerInterface
{
    private $propertyDescription;
    
    public function __construct($propertyDescription)
    {
        $this->propertyDescription = $propertyDescription;
    }
    
    /**
     * Transforma un valor escalar en un objeto
     * 
     * @param type $value
     * @return \AppBundle\Entity\Programas
     */
    
    public function reverseTransform($value) 
    {
        return $value['key'];
        
    }

    /**
     * Transforma un objeto en un valor scalar
     * 
     * @param type $value
     * @return string
     */
    public function transform($value) 
    {
        if($value == null) {
            return array('key' => null, 'description' => null);
        }
        
        $propertyAccessor = new PropertyAccessor();
        $description = $propertyAccessor->getValue($value, $this->propertyDescription);
        
        return array('key' => $value, 'description' => $description);
    }

//put your code here
}
