<?php
/**
 * Created by PhpStorm.
 * User: mihiran-hlrm
 * Date: 5/8/18
 * Time: 6:05 PM
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Witness;

class WitnessType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('loans', 'entity', array(
                'class'=>'AppBundle:Loan',
                'required'=>true,
                'multiple'=>true,
            ))
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
            'data_class' => Witness::class,
        ));
    }

    public function getName()
    {
        return 'app_witness';
    }
}