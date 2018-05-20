<?php
/**
 * Created by PhpStorm.
 * User: mihiran-hlrm
 * Date: 5/10/18
 * Time: 12:32 PM
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Admin;

class AdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('password', 'password')
            ->add('save', 'submit')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Admin::class,
        ));
    }

    public function getName()
    {
        return 'app_admin';
    }
}