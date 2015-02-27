<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AlmacenesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('domicilio')
            ->add('nombreResponsableAlmacen')
            ->add('cargoResponsableAlmacen')
            ->add('nombreRecursosMateriales')
            ->add('cargoRecursosMateriales')
            ->add('nombreJefeServicios')
            ->add('lugar')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Almacenes'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'AlmacenesType';
    }
}
