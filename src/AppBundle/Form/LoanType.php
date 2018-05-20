<?php
/**
 * Created by PhpStorm.
 * User: mihiran-hlrm
 * Date: 5/8/18
 * Time: 6:04 PM
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Loan;

class LoanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('customer', 'entity', array(
                'class'=>'AppBundle:Customer',
                'required'=>true,
            ))
            ->add('loanAmount', 'number')
            ->add('loanCode', 'text')
            ->add('startedDate', 'date')
            ->add('interest', 'percent')
            ->add('period', 'integer')
            ->add('isComplete', 'integer')
            ->add('save', 'submit')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Loan::class,
        ));
    }

    public function getName()
    {
        return 'app_loan';
    }
}