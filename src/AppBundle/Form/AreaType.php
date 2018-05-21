<?php
/**
 * Created by PhpStorm.
 * User: mihiran-hlrm
 * Date: 5/21/18
 * Time: 2:57 PM
 */

namespace AppBundle\Form;

use AppBundle\Entity\Area;
use AppBundle\Entity\Customer;
use AppBundle\Entity\Discount;
use Doctrine\DBAL\Types\DateType;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Loan;

class AreaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('areaName', TextType::class)
            ->add('areaCode', TextType::class)
            ->add('loans', CollectionType::class, array(
                'entry_type'   => LoanType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'required'     => false,
                'by_reference' => true,
                'delete_empty' => true,
            ))
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Area::class,
        ));
    }

    public function getName()
    {
        return 'app_area';
    }
}