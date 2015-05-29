<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use SSA\UtilidadesBundle\Form\Type\SearchKeyType;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Description of DemoForm
 *
 * @author jsr
 */
class KardexType extends AbstractType 
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('articulo', 'text', array(
                'required' => true,
                'constraints' => array(
                    new NotBlank(),
                ),
            ))
            ->add('programa', 'search_key', array(
                'class' => 'AppBundle:Programas',
                'required' => false,
                'property_key' => 'clave',
                'property_description' => 'nombre'
            ))
            ->add('fechaInicial', 'date',array(
                'widget' => 'single_text',
                
                'required' => false,
                    'format' => 'dd/MM/y',
                'attr' => array(
                    'class' => 'datepicker', 
                    'data-mask' => '99/99/9999',
                    'data-mask-placeholder' => '-',
                ),
                'widget_addon_prepend' => array('icon' => 'calendar')
            ))
            ->add('fechaFinal', 'date',array(
                'widget' => 'single_text',
                
                'required' => false,
                    'format' => 'dd/MM/y',
                'attr' => array(
                    'class' => 'datepicker', 
                    'data-mask' => '99/99/9999',
                    'data-mask-placeholder' => '-',
                ),
                'widget_addon_prepend' => array('icon' => 'calendar')
            ))
            
            ;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'attr'       => array(
                'class' => 'form-horizontal',
                'id' => $this->getName(),
            )
        ));
    }
    
    public function getName() 
    {
        return "kardex_type";
    }

//put your code here
}
