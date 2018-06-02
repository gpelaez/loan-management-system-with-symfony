<?php
/**
 * Created by PhpStorm.
 * User: mihiran-hlrm
 * Date: 5/1/18
 * Time: 10:35 AM
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Installment;

class BaseController extends Controller
{
    public function updateLoanByCalculations($loan)
    {
        $totalAmount = round($loan->getLoanAmount() * (1 + $loan->getInterest()), 2);

        $amountPerDay = round($totalAmount / ($loan->getPeriod()), 2);

        $weeklyPayment = round($amountPerDay * 7);

        $totalPayment = 0;
        foreach ($loan->getInstallments() as $installment) {
            $totalPayment += $installment->getInstallmentAmount();
        }

        $totalPaymentDates = round($totalPayment / $amountPerDay, 2);

        $dateDiff = date_diff(new \DateTime(), $loan->getStartedDate())->format('%a');

        $areasAmount = ($dateDiff * $amountPerDay) - $totalPayment;

        $areasAmountDates = round($areasAmount / $amountPerDay, 2);

        $installments = $this->getDoctrine()
            ->getRepository(Installment::class)
            ->findBy(
                array('loan' => $loan),
                array('paymentDate' => 'DESC')
            );

        $lastInstallmentAmount = 0;

        if ($installments) {
            $lastInstallmentAmount = $installments[0]->getInstallmentAmount();
        }

        $lastInstallmentAmountDates = round($lastInstallmentAmount / $amountPerDay, 2);


        $loan->setTotalAmount($totalAmount);
        $loan->setWeeklyPayment($weeklyPayment);
        $loan->setTotalPayment($totalPayment);
        $loan->setTotalPaymentDates($totalPaymentDates);
        $loan->setAreasAmount($areasAmount);
        $loan->setAreasAmountDates($areasAmountDates);
        $loan->setLastInstallmentAmount($lastInstallmentAmount);
        $loan->setLastInstallmentAmountDates($lastInstallmentAmountDates);

        return $loan;
    }
}