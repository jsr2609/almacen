<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Entity\EntradaDetalles; 

class EntradaDetallesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $withInput = 'col-sm-6 col-md-12  col-lg-9';
        $widthLabel = 'col-sm-6 col-md-12 col-lg-3';
        if($options['mostrar_campo_articulo']) {
            $builder
                ->add('articulo', 'entity_id', array(
                    'class' => "AppBundle:Articulos",
                    'property' => 'clave',
                    'widget_addon_prepend' => array('icon' => 'search'),
                    'hidden' => false,
                    'horizontal_label_class' => $widthLabel,
                    'horizontal_input_wrapper_class' => $withInput,
                    'attr' => array(
                        'data-toggle' => 'tooltip',
                        'title' => 'Ingrese la clave o de click en el botón para buscar un artículo.'
                    )
                ));
        }
        $builder
            ->add('cantidad', 'integer', array(                
                'horizontal_label_class' => $widthLabel,
                'horizontal_input_wrapper_class' => $withInput,
                'required' => true,
            ))
            ->add('precio', 'money', array(  
                'currency' => 'MXN',
                'horizontal_label_class' => $widthLabel,
                'horizontal_input_wrapper_class' => $withInput,
            ))
            ->add('aplicaIva', 'choice', array(
                'required' => true,
                'label' => 'Aplica IVA',
                'multiple' => false,
                'expanded' => true,
                'choices' => EntradaDetalles::$aplicaIvaOpciones,
                'widget_type'  => 'inline',
                'help_block' => 'Marque si se aplica el IVA al precio',                
                'horizontal_label_class' => $widthLabel,
                'horizontal_input_wrapper_class' => $withInput,
              
            ))
            ->add('fechaCaducidad', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd/MM/y',
                'attr' => array(
                    'class' => 'datepicker', 
                    'data-mask' => '99/99/9999',
                    'data-mask-placeholder' => '-',
                ),
                'widget_addon_prepend' => array('icon' => 'calendar'),
                'horizontal_label_class' => $widthLabel,
                'horizontal_input_wrapper_class' => $withInput,
                'label' => 'Caducidad',
                'required' => false,
            ))
            ->add('lote', 'text', array(
                'horizontal_label_class' => $widthLabel,
                'horizontal_input_wrapper_class' => $withInput,
                'required' => false
            ))
            
            ->add('observaciones', 'textarea', array(                
                'horizontal_label_class' => $widthLabel,
                'horizontal_input_wrapper_class' => $withInput,
                'required' => false,
            ))
            ->add('entrada', 'entity_id', array(
                'class' => 'AppBundle:Entradas',
                'label_render' => false,
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
            'attr' => array('class' => 'form-horizontal', 'id' => $this->getName()),
            'mostrar_campo_articulo' => true,            
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