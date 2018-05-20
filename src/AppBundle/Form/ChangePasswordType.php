<?php
/**
 * Created by PhpStorm.
 * User: mihiran-hlrm
 * Date: 5/13/18
 * Time: 5:42 PM
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\ChangePassword;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', 'password')
            ->add('newPassword', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'The password fields must match !',
                'required' => true,
                'first_options' => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ))
            ->add('save', 'submit');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ChangePassword::class,
        ));
    }

    public function getName()
    {
        return 'app_change_password';
    }
}