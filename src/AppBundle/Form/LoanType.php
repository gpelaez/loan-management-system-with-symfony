<?php
/**
 * Created by PhpStorm.
 * User: mihiran-hlrm
 * Date: 5/8/18
 * Time: 6:04 PM
 */

namespace AppBundle\Form;

use AppBundle\Entity\Area;
use AppBundle\Entity\Customer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Loan;

class LoanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', IntegerType::class)
            ->add('loanAmount', NumberType::class)
            ->add('loanCode', TextType::class)
            ->add('startedDate', DateType::class)
            ->add('interest', PercentType::class)
            ->add('period', IntegerType::class)
            ->add('isComplete', IntegerType::class)
            ->add('totalAmount', NumberType::class)
            ->add('weeklyPayment', NumberType::class)
            ->add('totalPayment', NumberType::class)
            ->add('totalPaymentDates', NumberType::class)
            ->add('areasAmount', NumberType::class)
            ->add('areasAmountDates', NumberType::class)
            ->add('lastInstallmentAmount', NumberType::class)
            ->add('lastInstallmentAmountDates', NumberType::class)
            ->add('area', EntityType::class, array(
                'class'=>Area::class,
            ))
            ->add('customer', EntityType::class, array(
                'class'=>Customer::class,
            ))
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