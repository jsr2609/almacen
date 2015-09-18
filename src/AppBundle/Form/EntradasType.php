<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Entity\Entradas;

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
                'required' => false,
                'attr' => array(
                    'readonly' => true
                )
            ))
            ->add('folioManual', 'text', array(
                'label' => 'Folio Manual',
                'help_block' => 'Folio que asigna el área de revisar documentos.',
                'required' => false,
                'attr' => array(
                    'readonly' => false
                )
            ))
            ->add('fecha', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd/MM/y',
                'attr' => array(
                    'class' => 'datepicker', 
                    'data-mask' => '99/99/9999',
                    'data-mask-placeholder' => '-',
                ),
                'widget_addon_prepend' => array('icon' => 'calendar'),
            ))
            ->add('tipoCompra', 'choice', array(
                'label' => 'Tipo de Compra',
                'empty_value' => 'Seleccione...',
                'choices' => Entradas::$pedidoTiposCompra,
                'expanded' => false,
                'widget_type'  => 'inline'
            ))
            ->add('programa', 'search_key', array(
                'class' => 'AppBundle:Programas',
                'property_key' => 'clave',
                'property_description' => 'nombre'
            ))
            ->add('proveedor', 'search_key', array(
                'class' => 'AppBundle:Proveedores',
                'property_key' => 'rfc',
                'property_description' => 'nombre'
            ))
            ->add('facturaNumero', 'text', array(
                'label' => 'Numero de Factura',
                'required' => false,
            ))
            ->add('facturaFecha', 'date', array(
                'widget' => 'single_text',
                'label' => 'Fecha de Factura',
                'required' => false,
                'format' => 'dd/MM/y',
                'attr' => array(
                    'class' => 'datepicker', 
                    'data-mask' => '99/99/9999',
                    'data-mask-placeholder' => '-',
                ),
                'widget_addon_prepend' => array('icon' => 'calendar'),
            ))
            ->add('numeroRemision', 'text', array(
                'label' => 'Numero de Remisión',
                'required' => false,
            ))
            ->add('pedidoNumero', 'text', array(
                'label' => 'Número de Pedido',
                'required' => false,
            ))
            ->add('compra', 'choice', array(
                'label' => 'Tipo de pedido',
                'choices' => Entradas::$pedidoTipos,
                'expanded' => true,
                'widget_type'  => 'inline',
                'required' => false,
                'empty_value' => false,
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
