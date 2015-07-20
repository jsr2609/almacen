<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Entity\SalidaDetalles; 

class SalidaDetallesType extends AbstractType
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
            ->add('entradaDetalle', 'entity_id', array(
                'class' => "AppBundle:EntradaDetalles",
                'label' => 'Entrada ',
                'help_block' => 'Seleccione la Entrada.',
                'property' => 'id',
                'widget_addon_prepend' => array('icon' => 'search'),
                'hidden' => false,
                'horizontal_label_class' => $widthLabel,
                'horizontal_input_wrapper_class' => $withInput,
                'required' => true,
                'attr' => array(
                    'readonly' => true,
                )
            ))
            ->add('cantidad', 'integer', array(                
                'horizontal_label_class' => $widthLabel,
                'horizontal_input_wrapper_class' => $withInput,
                'required' => true,
            ))
            ->add('origen', 'hidden', array(
                 'mapped' => false,
                 'data'   => "ED",
            ));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\SalidaDetalles',
            'attr' => array('class' => 'form-horizontal', 'id' => $this->getName()),
            'mostrar_campo_articulo' => true,            
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'salida_detalles_type';
    }
}
