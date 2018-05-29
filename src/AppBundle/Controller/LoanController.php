<?php
/**
 * Created by PhpStorm.
 * User: mihiran-hlrm
 * Date: 5/3/18
 * Time: 2:22 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Area;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Loan;
use AppBundle\Entity\Customer;
use AppBundle\Entity\Witness;
use AppBundle\Entity\Installment;

class LoanController extends BaseController
{
    /**
     * @Route("/dashboard/area/{areaId}/loan", name="loan")
     */
    public function Loan(Request $request, $areaId)
    {
        $search = $request->get('search');
        if ($search) {
            $loans = $this->getDoctrine()
                ->getRepository(Loan::class)
                ->findLoansBySearch($areaId, $search);
        } else {
            $loans = $this->getDoctrine()
                ->getRepository(Loan::class)
                ->findLoansByAreaId($areaId);
        }

        foreach ($loans as $loan) {

            $totalAmount = round($loan->getLoanAmount() * (1 + $loan->getInterest()), 2 );

            $amountPerDay = round($totalAmount / ($loan->getPeriod()), 2);

            $weeklyPayment = $amountPerDay * 7;

            $totalPayment = 0;
            foreach($loan->getInstallments() as $installment)
            {
                $totalPayment += $installment->getInstallmentAmount();
            }

            $totalPaymentDates = round($totalPayment/$amountPerDay, 2);

            $dateDiff = date_diff(new \DateTime(), $loan->getStartedDate())->format('%d');

            $areasAmount = ($dateDiff * $amountPerDay) - $totalPayment;

            $areasAmountDates = round($areasAmount/$amountPerDay, 2);

            $installments = $this->getDoctrine()
                ->getRepository(Installment::class)
                ->findBy(
                    array('loan'=>$loan),
                    array('paymentDate' => 'DESC')
                );

            $lastInstallmentAmount=0;

            if($installments) {
                $lastInstallmentAmount = $installments[0]->getInstallmentAmount();
            }

            $lastInstallmentAmountDates =  round($lastInstallmentAmount/$amountPerDay, 2);


            $loan->setTotalAmount($totalAmount);
            $loan->setWeeklyPayment($weeklyPayment);
            $loan->setTotalPayment($totalPayment);
            $loan->setTotalPaymentDates($totalPaymentDates);
            $loan->setAreasAmount($areasAmount);
            $loan->setAreasAmountDates($areasAmountDates);
            $loan->setLastInstallmentAmount($lastInstallmentAmount);
            $loan->setLastInstallmentAmountDates($lastInstallmentAmountDates);
        }

//        $paginator  = $this->get('knp_paginator');
//        $pagination = $paginator->paginate(
//            $loans, /* query NOT result */
//            $request->query->getInt('page', 1)/*page number*/,
//            7/*limit per page*/
//        );

        return $this->render('loan/loan.html.twig', array(
            'areaId'=>$areaId,
            'loans'=>$loans,
        ));
    }

    /**
     * @Route("/dashboard/loan/{loanId}/add-installment/{installmentAmount}", name="addInstallment")
     */
    public function addInstallment(Request $request, $loanId, $installmentAmount)
    {
        $loan = $this->getDoctrine()
            ->getRepository(Loan::class)
            ->find($loanId);

        if (!$loan) {
            throw $this->createNotFoundException(
                'No Loan Found !'
            );
        }

        $installment = new Installment();
        $installment->setInstallmentAmount($installmentAmount);
        $installment->setPaymentDate(new \DateTime());
        $installment->setLoan($loan);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($installment);
        $entityManager->flush();


        $totalAmount = round($loan->getLoanAmount() * (1 + $loan->getInterest()), 2 );

        $amountPerDay = round($totalAmount / ($loan->getPeriod()), 2);

        $weeklyPayment = $amountPerDay * 7;

        $totalPayment = 0;
        foreach($loan->getInstallments() as $installment)
        {
            $totalPayment += $installment->getInstallmentAmount();
        }

        $totalPaymentDates = round($totalPayment/$amountPerDay, 2);

        $dateDiff = date_diff(new \DateTime(), $loan->getStartedDate())->format('%d');

        $areasAmount = ($dateDiff * $amountPerDay) - $totalPayment;

        $areasAmountDates = round($areasAmount/$amountPerDay, 2);

        $installments = $this->getDoctrine()
            ->getRepository(Installment::class)
            ->findBy(
                array('loan'=>$loan),
                array('paymentDate' => 'DESC')
            );

        $lastInstallmentAmount=0;

        if($installments) {
            $lastInstallmentAmount = $installments[0]->getInstallmentAmount();
        }

        $lastInstallmentAmountDates =  round($lastInstallmentAmount/$amountPerDay, 2);


        $loan->setTotalAmount($totalAmount);
        $loan->setWeeklyPayment($weeklyPayment);
        $loan->setTotalPayment($totalPayment);
        $loan->setTotalPaymentDates($totalPaymentDates);
        $loan->setAreasAmount($areasAmount);
        $loan->setAreasAmountDates($areasAmountDates);
        $loan->setLastInstallmentAmount($lastInstallmentAmount);
        $loan->setLastInstallmentAmountDates($lastInstallmentAmountDates);

        $data = array(
            'totalPayment'=>$totalPayment,
            'totalPaymentDates'=>$totalPaymentDates,
            'areasAmount'=>$areasAmount,
            'areasAmountDates'=>$areasAmountDates,
            'lastInstallmentAmount'=>$lastInstallmentAmount,
            'lastInstallmentAmountDates'=>$lastInstallmentAmountDates,
        );

        return new JsonResponse($data);
    }

    /**
     * @Route("/dashboard/area/{areaId}/loan/view/{loanId}", name="loanView")
     */
    public function loanView(Request $request, $areaId, $loanId)
    {
        $loan = $this->getDoctrine()
            ->getRepository(Loan::class)
            ->find($loanId);

        if (!$loan) {
            throw $this->createNotFoundException(
                'No Loan Found !'
            );
        }

        $totalAmount = round($loan->getLoanAmount() * (1 + $loan->getInterest()), 2 );

        $amountPerDay = round($totalAmount / ($loan->getPeriod()), 2);

        $weeklyPayment = $amountPerDay * 7;

        $totalPayment = 0;
        foreach($loan->getInstallments() as $installment)
        {
            $totalPayment += $installment->getInstallmentAmount();
        }

        $totalPaymentDates = round($totalPayment/$amountPerDay, 2);

        $dateDiff = date_diff(new \DateTime(), $loan->getStartedDate())->format('%d');

        $areasAmount = ($dateDiff * $amountPerDay) - $totalPayment;

        $areasAmountDates = round($areasAmount/$amountPerDay, 2);

        $installments = $this->getDoctrine()
            ->getRepository(Installment::class)
            ->findBy(
                array('loan'=>$loan),
                array('paymentDate' => 'DESC')
            );

        $lastInstallmentAmount=0;

        if($installments) {
            $lastInstallmentAmount = $installments[0]->getInstallmentAmount();
        }

        $lastInstallmentAmountDates =  round($lastInstallmentAmount/$amountPerDay, 2);

        return $this->render('loan/loanView.html.twig', array(
            'areaId'=>$areaId,
            'loanId'=>$loanId,
            'loan'=>$loan,
            'totalAmount'=>$totalAmount,
            'weeklyPayment'=>$weeklyPayment,
            'totalPayment'=>$totalPayment,
            'totalPaymentDates'=>$totalPaymentDates,
            'areasAmount'=>$areasAmount,
            'areasAmountDates'=>$areasAmountDates,
            'lastInstallmentAmount'=>$lastInstallmentAmount,
            'lastInstallmentAmountDates'=>$lastInstallmentAmountDates,
        ));
    }

    /**
     * @Route("/dashboard/area/{areaId}/loan/edit/{loanId}", name="loanEdit")
     */
    public function loanEdit(Request $request, $areaId, $loanId)
    {
        $loan = $this->getDoctrine()
            ->getRepository(Loan::class)
            ->find($loanId);

        if (!$loan) {
            throw $this->createNotFoundException(
                'No Loan Found !'
            );
        }

        if ($request->isMethod('post')) {

            $customerName = $request->get('customerName');
            $customerNic = $request->get('customerNic');
            $customerAddress = $request->get('customerAddress');
            $customerMobile = $request->get('customerMobile');
            $customerFixed = $request->get('customerFixed');

            $loanAmount = $request->get('loanAmount');
            $loanCode = $request->get('loanCode');
            $loanStartedDate = $request->get('loanStartedDate');
            $loanInterest = $request->get('loanInterest');
            $loanPeriod = $request->get('loanPeriod');
            $loanIsComplete = $request->get('loanIsComplete');

            $witness1Name = $request->get('witness1Name');
            $witness1Nic = $request->get('witness1Nic');
            $witness1Address = $request->get('witness1Address');
            $witness1Mobile = $request->get('witness1Mobile');
            $witness1Fixed = $request->get('witness1Fixed');

            $witness2Name = $request->get('witness2Name');
            $witness2Nic = $request->get('witness2Nic');
            $witness2Address = $request->get('witness2Address');
            $witness2Mobile = $request->get('witness2Mobile');
            $witness2Fixed = $request->get('witness2Fixed');

            $customer = $this->getDoctrine()
                ->getRepository(Customer::class)
                ->findCustomerByNic($customerNic);

            if (!$customer) {
                $customer = new Customer();
            }

            $customer->setName($customerName);
            $customer->setNic($customerNic);
            $customer->setAddress($customerAddress);
            $customer->setMobile($customerMobile);
            $customer->setFixed($customerFixed);

            $witness1 = $this->getDoctrine()
                ->getRepository(Witness::class)
                ->findWitnessByNic($witness1Nic);

            if (!$witness1) {
                $witness1 = new Witness();
            }

            $witness1->setName($witness1Name);
            $witness1->setNic($witness1Nic);
            $witness1->setAddress($witness1Address);
            $witness1->setMobile($witness1Mobile);
            $witness1->setFixed($witness1Fixed);

            $witness2 = $this->getDoctrine()
                ->getRepository(Witness::class)
                ->findWitnessByNic($witness2Nic);

            if (!$witness2) {
                $witness2 = new Witness();
            }

            $witness2->setName($witness2Name);
            $witness2->setNic($witness2Nic);
            $witness2->setAddress($witness2Address);
            $witness2->setMobile($witness2Mobile);
            $witness2->setFixed($witness2Fixed);

            $loan->setLoanAmount($loanAmount);
            $loan->setLoanCode($loanCode);
            $loan->setStartedDate(new \DateTime($loanStartedDate));
            $loan->setInterest($loanInterest);
            $loan->setPeriod($loanPeriod);
            $loan->setIsComplete($loanIsComplete);
            $loan->setCustomer($customer);
            $loan->setFirstWitness($witness1);
            $loan->setSecondWitness($witness2);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($customer);
            $entityManager->persist($witness1);
            $entityManager->persist($witness2);
            $entityManager->persist($loan);
            $entityManager->flush();

            return $this->redirectToRoute('loanEdit', array(
                'areaId'=>$areaId,
                'loanId'=>$loanId,
            ));
        }

        $customerName = $loan->getCustomer()->getName();
        $customerNic = $loan->getCustomer()->getNic();
        $customerAddress = $loan->getCustomer()->getAddress();
        $customerMobile = $loan->getCustomer()->getMobile();
        $customerFixed = $loan->getCustomer()->getFixed();

        $loanAmount = $loan->getLoanAmount();
        $loanCode = $loan->getLoanCode();
        $loanStartedDate = $loan->getStartedDate();
        $loanInterest = $loan->getInterest();
        $loanPeriod = $loan->getPeriod();
        $loanIsComplete = $loan->getIsComplete();

        $witness1Name = $loan->getWitnesses()[0]->getName();
        $witness1Nic = $loan->getWitnesses()[0]->getNic();
        $witness1Address = $loan->getWitnesses()[0]->getAddress();
        $witness1Mobile = $loan->getWitnesses()[0]->getMobile();
        $witness1Fixed = $loan->getWitnesses()[0]->getFixed();

        $witness2Name = $loan->getWitnesses()[1]->getName();
        $witness2Nic = $loan->getWitnesses()[1]->getNic();
        $witness2Address = $loan->getWitnesses()[1]->getAddress();
        $witness2Mobile = $loan->getWitnesses()[1]->getMobile();
        $witness2Fixed = $loan->getWitnesses()[1]->getFixed();

        return $this->render('loan/loanEdit.html.twig', array(
            'areaId'=>$areaId,

            'customerName'=>$customerName,
            'customerNic'=>$customerNic,
            'customerAddress'=>$customerAddress,
            'customerMobile'=>$customerMobile,
            'customerFixed'=>$customerFixed,

            'loanId'=>$loanId,
            'loanAmount'=>$loanAmount,
            'loanCode'=>$loanCode,
            'loanStartedDate'=>$loanStartedDate,
            'loanInterest'=>$loanInterest,
            'loanPeriod'=>$loanPeriod,
            'loanIsComplete'=>$loanIsComplete,

            'witness1Name'=>$witness1Name,
            'witness1Nic'=>$witness1Nic,
            'witness1Address'=>$witness1Address,
            'witness1Mobile'=>$witness1Mobile,
            'witness1Fixed'=>$witness1Fixed,

            'witness2Name'=>$witness2Name,
            'witness2Nic'=>$witness2Nic,
            'witness2Address'=>$witness2Address,
            'witness2Mobile'=>$witness2Mobile,
            'witness2Fixed'=>$witness2Fixed,
        ));
    }

    /**
     * @Route("/dashboard/area/{areaId}/loan/add", name="loanAdd")
     */
    public function loanAdd(Request $request, $areaId)
    {
        if ($request->isMethod('post')) {

            $area = $this->getDoctrine()
                ->getRepository(Area::class)
                ->find($areaId);

            if (!$area) {
                throw $this->createNotFoundException(
                    'No Area Found !'
                );
            }

            $customerName = $request->get('customerName');
            $customerNic = $request->get('customerNic');
            $customerAddress = $request->get('customerAddress');
            $customerMobile = $request->get('customerMobile');
            $customerFixed = $request->get('customerFixed');

            $loanAmount = $request->get('loanAmount');
            $loanCode = $request->get('loanCode');
            $loanStartedDate = $request->get('loanStartedDate');
            $loanInterest = $request->get('loanInterest');
            $loanPeriod = $request->get('loanPeriod');

            $witness1Name = $request->get('witness1Name');
            $witness1Nic = $request->get('witness1Nic');
            $witness1Address = $request->get('witness1Address');
            $witness1Mobile = $request->get('witness1Mobile');
            $witness1Fixed = $request->get('witness1Fixed');

            $witness2Name = $request->get('witness2Name');
            $witness2Nic = $request->get('witness2Nic');
            $witness2Address = $request->get('witness2Address');
            $witness2Mobile = $request->get('witness2Mobile');
            $witness2Fixed = $request->get('witness2Fixed');

            $customer = $this->getDoctrine()
                ->getRepository(Customer::class)
                ->findCustomerByNic($customerNic);

            if (!$customer) {
                $customer = new Customer();
            }

            $customer->setName($customerName);
            $customer->setNic($customerNic);
            $customer->setAddress($customerAddress);
            $customer->setMobile($customerMobile);
            $customer->setFixed($customerFixed);

            $witness1 = $this->getDoctrine()
                ->getRepository(Witness::class)
                ->findWitnessByNic($witness1Nic);

            if (!$witness1) {
                $witness1 = new Witness();
            }

            $witness1->setName($witness1Name);
            $witness1->setNic($witness1Nic);
            $witness1->setAddress($witness1Address);
            $witness1->setMobile($witness1Mobile);
            $witness1->setFixed($witness1Fixed);

            $witness2 = $this->getDoctrine()
                ->getRepository(Witness::class)
                ->findWitnessByNic($witness2Nic);

            if (!$witness2) {
                $witness2 = new Witness();
            }

            $witness2->setName($witness2Name);
            $witness2->setNic($witness2Nic);
            $witness2->setAddress($witness2Address);
            $witness2->setMobile($witness2Mobile);
            $witness2->setFixed($witness2Fixed);

            $loan = new Loan();
            $loan->setLoanAmount($loanAmount);
            $loan->setLoanCode($loanCode);
            $loan->setStartedDate(new \DateTime($loanStartedDate));
            $loan->setInterest($loanInterest);
            $loan->setPeriod($loanPeriod);
            $loan->setArea($area);
            $loan->setCustomer($customer);
            $loan->addWitness($witness1);
            $loan->addWitness($witness2);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($area);
            $entityManager->persist($customer);
            $entityManager->persist($witness1);
            $entityManager->persist($witness2);
            $entityManager->persist($loan);
            $entityManager->flush();

            return $this->redirectToRoute('loanAdd', array(
                'areaId'=>$areaId,
            ));
        }

        return $this->render('loan/loanAdd.html.twig', array(
            'areaId'=>$areaId,
        ));
    }

    /**
     * @Route("/dashboard/area/{areaId}/loan/complete", name="loanComplete")
     */
    public function loanComplete(Request $request, $areaId)
    {
        $search = $request->get('search');
        if ($search) {
            $loans = $this->getDoctrine()
                ->getRepository(Loan::class)
                ->findCompletedLoansBySearch($areaId, $search);
        } else {
            $loans = $this->getDoctrine()
                ->getRepository(Loan::class)
                ->findCompletedLoansByAreaId($areaId);
        }

        foreach ($loans as $loan) {

            $totalAmount = round($loan->getLoanAmount() * (1 + $loan->getInterest()), 2 );

            $amountPerDay = round($totalAmount / ($loan->getPeriod()), 2);

            $weeklyPayment = $amountPerDay * 7;

            $totalPayment = 0;
            foreach($loan->getInstallments() as $installment)
            {
                $totalPayment += $installment->getInstallmentAmount();
            }

            $totalPaymentDates = round($totalPayment/$amountPerDay, 2);

            $dateDiff = date_diff(new \DateTime(), $loan->getStartedDate())->format('%d');

            $areasAmount = ($dateDiff * $amountPerDay) - $totalPayment;

            $areasAmountDates = round($areasAmount/$amountPerDay, 2);

            $installments = $this->getDoctrine()
                ->getRepository(Installment::class)
                ->findBy(
                    array('loan'=>$loan),
                    array('paymentDate' => 'DESC')
                );

            $lastInstallmentAmount=0;

            if($installments) {
                $lastInstallmentAmount = $installments[0]->getInstallmentAmount();
            }

            $lastInstallmentAmountDates =  round($lastInstallmentAmount/$amountPerDay, 2);


            $loan->setTotalAmount($totalAmount);
            $loan->setWeeklyPayment($weeklyPayment);
            $loan->setTotalPayment($totalPayment);
            $loan->setTotalPaymentDates($totalPaymentDates);
            $loan->setAreasAmount($areasAmount);
            $loan->setAreasAmountDates($areasAmountDates);
            $loan->setLastInstallmentAmount($lastInstallmentAmount);
            $loan->setLastInstallmentAmountDates($lastInstallmentAmountDates);
        }

//        $paginator  = $this->get('knp_paginator');
//        $pagination = $paginator->paginate(
//            $loans, /* query NOT result */
//            $request->query->getInt('page', 1)/*page number*/,
//            7/*limit per page*/
//        );

        return $this->render('loan/loanComplete.html.twig', array(
            'areaId'=>$areaId,
            'loans'=>$loans,
        ));
    }
}