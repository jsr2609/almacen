<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Entity\Salidas;

class SalidasType extends AbstractType
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
            ->add('tipoEntrada', 'choice', array(
                'label' => 'Tipo de Salida',
                'choices' => Salidas::$salidasTipos,
                'expanded' => true,
                'widget_type'  => 'inline'
            ))
           ->add('programa', 'search_key',array(
                'class' => 'AppBundle:Programas',
                'property_key' => 'clave',
                'property_description' => 'nombre'
            ))
           ->add('destino', 'search_key',array(
                'class' => 'AppBundle:Destinos',
                'property_key' => 'clave',
                'property_description' => 'nombre'
            ))
            ->add('areaQueRecibe','text',array(
                'label' => 'Area que Recibe',
                'required' => true,
            ))
            ->add('nombreQuienRecibe', 'text',array(
                'label' => 'Nombre de quien Recibe',
                'required' => false,
            ))
            ->add('observaciones', 'text',array(
                'label' => 'Observaciones',
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
            'data_class' => 'AppBundle\Entity\Salidas',
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
        return 'salidas_type';
    }
}
