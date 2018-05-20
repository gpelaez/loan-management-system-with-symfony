<?php
/**
 * Created by PhpStorm.
 * User: mihiran-hlrm
 * Date: 5/8/18
 * Time: 5:26 PM
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Customer;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('nic', 'text')
            ->add('address', 'text')
            ->add('mobile', 'text')
            ->add('fixed', 'text')
            ->add('save', 'submit')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Customer::class,
        ));
    }

    public function getName()
    {
        return 'app_customer';
    }
}