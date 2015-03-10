<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EntradasType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('folio', 'text', array(
                'help_block' => 'Folio generado automáticamente por el sistema.',
                'attr' => array(
                    'readonly' => true
                )
            ))
            ->add('fecha', 'date', array(
                'widget' => 'single_text',
                'attr' => array(
                    'class' => 'datepicker', 
                    'data-mask' => '99/99/9999',
                    'data-mask-placeholder' => '-',
                ),
                'widget_addon_prepend' => array('icon' => 'calendar'),
            ))
            ->add('tipoEntrada', 'entity', array(
                'label' => 'Tipo de Entrada',
                'class' => 'AppBundle:EntradaTipos',
                'expanded' => true,
                'widget_type'  => 'inline'
            ))
            ->add('programa', 'search_key', array(
                'class' => 'AppBundle:Programas'
            ))
            ->add('pedidoNumero', 'text', array(
                'label' => 'Número de Pedido',
                'required' => false,
            ))
            ->add('pedidoTipo', 'choice', array(
                'label' => 'Tipo de pedido',
                'choices' => array('Orden', 'Pedido', 'Propuesta', 'Otro'),
                'expanded' => true,
                'widget_type'  => 'inline',
                'required' => false,
                'empty_value' => false,
            ))
            ->add('proveedor', 'search_key', array(
                'class' => 'AppBundle:Proveedores'
            ))
            ->add('numeroFactura', 'text', array(
                'label' => 'Numero de Factura',
                'required' => false,
            ))
            ->add('fechaFactura', 'date', array(
                'widget' => 'single_text',
                'label' => 'Fecha de Factura',
                'required' => false,
            ))
            
            ->add('observaciones', 'textarea', array(
                'required' => false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Entradas',
            'attr'       => array(
                'class' => 'form-horizontal',
                'id' => $this->getName(),
            )
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'entradas_type';
    }
}