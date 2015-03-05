<?php

namespace SSA\UtilidadesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ParametrosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('valor')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SSA\UtilidadesBundle\Entity\Parametros',
            'attr' => array(
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
        return 'parametros_type';
    }
}
