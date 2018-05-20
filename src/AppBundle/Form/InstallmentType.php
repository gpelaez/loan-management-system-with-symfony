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
use AppBundle\Entity\Installment;

class InstallmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('loan', 'entity', array(
                'class'=>'AppBundle:Loan',
                'required'=>true,
            ))
            ->add('installmentAmount', 'number')
            ->add('paymentDate', 'date')
            ->add('save', 'submit')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Installment::class,
        ));
    }

    public function getName()
    {
        return 'app_installment';
    }
}