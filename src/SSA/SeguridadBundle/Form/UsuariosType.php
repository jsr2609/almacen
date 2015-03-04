<?php

namespace SSA\SeguridadBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use SSA\SeguridadBundle\Form\PerfilesType;

class UsuariosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('usuario')
            ->add('password', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'Las contraseñas deben ser iguales.',
                'options' => array('attr' => array('class' => 'password-field')),
                'required' => false,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repetir Password'),
            ))
            ->add('email')
            
            ->add('nombre')
            ->add('apellidoPaterno')
            ->add('apellidoMaterno')
            ->add('grupos', null, array(
                'expanded' => true,
            ))
            ->add('perfil', new PerfilesType(), array(
                "label" => false
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SSA\SeguridadBundle\Entity\Usuarios',
            'attr' => array(
                'class' => 'form-horizontal',
                'id' => $this->getName(),
            ),
            'cascade_validation' => true,
            'validation_groups' => array('nuevo'),            
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'UsuariosType';
    }
}
