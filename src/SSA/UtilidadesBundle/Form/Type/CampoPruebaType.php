<?php

namespace SSA\UtilidadesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

class CampoPruebaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('key', 'entity_id', array(
                'class' => $options['class'],
                'hidden' => false,
                'widget_addon_prepend' => array('icon' => 'search'),
                'label' => false,
                'horizontal_input_wrapper_class' => $options['horizontal_input_wrapper_class_key'],
            ))
            ->add('description', 'text',array(
                'horizontal_input_wrapper_class' => $options['horizontal_input_wrapper_class_description'],
                'label' => false,
                'attr' => array('readonly' => true)
            ))
            ;
        
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'horizontal_input_wrapper_class' => 'col-sm-9 col-md-9  col-lg-10',
            'class' => null,
            'horizontal_input_wrapper_class_key' => 'col-sm-12 col-md-4 col-lg-3',
            'horizontal_input_wrapper_class_description' => 'col-sm-12 col-md-8 col-lg-9',
        ));
    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'campoprueba';
    }
}