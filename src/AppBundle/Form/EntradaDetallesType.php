<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EntradaDetallesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('articulo', 'entity_id', array(
                'class' => "AppBundle:Articulos",
                'widget_addon_prepend' => array('icon' => 'search'),
                'hidden' => false,
                'horizontal_label_class' => 'col-sm-6 col-md-5 col-lg-4',
                'horizontal_input_wrapper_class' => 'col-sm-6 col-md-7  col-lg-8',
            ))
            ->add('cantidad', 'number', array(                
                'horizontal_label_class' => 'col-sm-6 col-md-5 col-lg-4',
                'horizontal_input_wrapper_class' => 'col-sm-6 col-md-7  col-lg-8',
            ))
            ->add('precio', 'text', array(                
                'horizontal_label_class' => 'col-sm-6 col-md-5 col-lg-4',
                'horizontal_input_wrapper_class' => 'col-sm-6 col-md-7  col-lg-8',
            ))
            ->add('aplicaIva', 'checkbox', array(
                'required' => false,
                'help_block' => 'Marque si se aplica el IVA al precio',                
                'horizontal_label_class' => 'col-sm-6 col-md-5 col-lg-4',
                'horizontal_input_wrapper_class' => 'col-sm-6 col-md-7  col-lg-8',
              
            ))
            ->add('observaciones', 'textarea', array(                
                'horizontal_label_class' => 'col-sm-6 col-md-5 col-lg-4',
                'horizontal_input_wrapper_class' => 'col-sm-6 col-md-7  col-lg-8',
            ))
          
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\EntradaDetalles',
            'attr' => array('class' => 'form-horizontal'),
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'entrada_detalles_type';
    }
}
