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

/**
 * Description of DemoForm
 *
 * @author jsr
 */
class DemoType extends AbstractType 
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', 'text', array(
            
            ))
            ->add('fecha', 'date',array(
                'widget' => 'single_text',
                
                'required' => true,
                    'format' => 'dd/MM/y',
                'attr' => array(
                    'class' => 'datepicker', 
                    'data-mask' => '99/99/9999',
                    'data-mask-placeholder' => '-',
                ),
                'widget_addon_prepend' => array('icon' => 'calendar')
            ));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            //'data_class' => 'NameSpaceEntidad',
        ));
    }
    
    public function getName() 
    {
        return "DemoType";
    }

//put your code here
}
