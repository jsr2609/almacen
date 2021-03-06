<?php

namespace SSA\UtilidadesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;
use SSA\UtilidadesBundle\Form\DataTransformer\SearchKeyDataTransformer;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Gregwar\FormBundle\DataTransformer\EntityToIdTransformer;
use SSA\UtilidadesBundle\Form\DataTransformer\SearchKeyViewTransformer;

class SearchKeyType extends AbstractType
{
    private $registry;
    
    public function __construct(RegistryInterface $registry)
    {
        $this->registry = $registry;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('key', 'entity_id', array(
                'class' => $options['class'],
                'hidden' => false,
                'property' => $options['property_key'],
                'widget_addon_prepend' => $options['widget_addon_prepend_key'],
                'label' => false,
                'horizontal_input_wrapper_class' => $options['horizontal_input_wrapper_class_key'],
                
            ))
            ->add('description', 'text',array(
                'horizontal_input_wrapper_class' => $options['horizontal_input_wrapper_class_description'],
                'label' => false,
                'attr' => array('readonly' => true),
                'required' => false,
            ))
            ;
        
            
        
    $builder->addModelTransformer(new SearchKeyDataTransformer($options['property_description']));        
        
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array(
            'class',
            'property_key',
            'property_description'
        ));
        $resolver->setDefaults(array(
            
            'horizontal_input_wrapper_class' => 'col-sm-9 col-md-9  col-lg-10',
            'widget_addon_prepend_key' => array('icon' => 'search'),
            'horizontal_input_wrapper_class_key' => 'col-sm-4 col-md-4 col-lg-3',
            'horizontal_input_wrapper_class_description' => 'col-sm-8 col-md-8 col-lg-9',
        ));
    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'search_key';
    }
}