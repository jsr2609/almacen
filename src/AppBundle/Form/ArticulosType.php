<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticulosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('clave')
            ->add('nombre')
            ->add('presentacion')
            ->add('cantidad')
            ->add('unidadMedidaPresentacion')
            ->add('activo')
            ->add('fechaCreacion')
            ->add('fechaActualizacion')
            ->add('partida')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Articulos'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_articulos';
    }
}
