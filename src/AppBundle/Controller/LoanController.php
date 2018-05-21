<?php
/**
 * Created by PhpStorm.
 * User: mihiran-hlrm
 * Date: 5/3/18
 * Time: 2:22 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Area;
use AppBundle\Form\AreaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\LoanType;
use AppBundle\Entity\Loan;
use AppBundle\Entity\Customer;
use AppBundle\Entity\Witness;
use AppBundle\Entity\Installment;

class LoanController extends BaseController
{
    /**
     * @Route("/dashboard/area/{id}/loan", name="loan")
     */
    public function Loan(Request $request, $id)
    {
        $area = $this->getDoctrine()
            ->getRepository(Area::class)
            ->find($id);

        if (!$area) {
            throw $this->createNotFoundException(
                'No Area Found !'
            );
        }

        foreach ($area->getLoans() as $loan) {

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

        $form = $this->createForm(AreaType::class, $area);

        $form->handleRequest($request);
        if ($form->isSubmitted() & $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($area);
            $entityManager->flush();

            return $this->redirectToRoute('loan', array('id' => $id));

        }

//        $paginator  = $this->get('knp_paginator');
//        $pagination = $paginator->paginate(
//            $loans, /* query NOT result */
//            $request->query->getInt('page', 1)/*page number*/,
//            7/*limit per page*/
//        );

        return $this->render('loan/loan.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/dashboard/loan/view/{id}", name="loanView")
     */
    public function loanView(Request $request, $id)
    {
        $loan = $this->getDoctrine()
            ->getRepository(Loan::class)
            ->find($id);

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

        $breadcrumbArray = array(
            array('Dashboard' , 'dashboard', ''),
            array('Loan' , 'loan', ''),
            array('View', '', ''),
            array($loan->getLoanCode() , '', ''),
        );

        return $this->render('loan/loanView.html.twig', array(
            'loan'=>$loan,
            'totalAmount'=>$totalAmount,
            'weeklyPayment'=>$weeklyPayment,
            'totalPayment'=>$totalPayment,
            'totalPaymentDates'=>$totalPaymentDates,
            'areasAmount'=>$areasAmount,
            'areasAmountDates'=>$areasAmountDates,
            'lastInstallmentAmount'=>$lastInstallmentAmount,
            'lastInstallmentAmountDates'=>$lastInstallmentAmountDates,
            'breadcrumbArray'=>$breadcrumbArray,
        ));
    }

    /**
     * @Route("/dashboard/loan/edit/{id}", name="loanEdit")
     */
    public function loanEdit(Request $request, $id)
    {
        $loan = $this->getDoctrine()
            ->getRepository(Loan::class)
            ->find($id);

        if (!$loan) {
            throw $this->createNotFoundException(
                'No loan found !'
            );
        }

        $form = $this->createForm(new LoanType(), $loan);

        $form->handleRequest($request);
        if ($form->isSubmitted() & $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($loan);
            $entityManager->flush();

            return $this->redirectToRoute('loanEdit', array('id' => $loan->getId()));
        }

        $breadcrumbArray = array(
            array('Dashboard' , 'dashboard', ''),
            array('Loan' , 'loan', ''),
            array('Edit', '', ''),
            array($loan->getLoanCode() , '', ''),
        );

        return $this->render('loan/loanEdit.html.twig', array(
            'form' => $form->createView(),
            'breadcrumbArray'=>$breadcrumbArray,
        ));
    }

    /**
     * @Route("/dashboard/loan/add", name="loanAdd")
     */
    public function loanAdd(Request $request)
    {
        $loan = new Loan();
        $form = $this->createForm(new LoanType(), $loan);

        $form->handleRequest($request);
        if ($form->isSubmitted() & $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($loan);
            $entityManager->flush();

            return $this->redirectToRoute('loanAdd');
        }

        $breadcrumbArray = array(
            array('Dashboard' , 'dashboard', ''),
            array('Loan' , 'loan', ''),
            array('Add', '', ''),
        );

        return $this->render('loan/loanAdd.html.twig', array(
            'form' => $form->createView(),
            'breadcrumbArray'=>$breadcrumbArray,
        ));
    }

    /**
     * @Route("/dashboard/loan/complete", name="loanComplete")
     */
    public function loanComplete(Request $request)
    {
        $search = $request->get('search');

        if($search) {
            $loans = $this->getDoctrine()
                ->getRepository(Loan::class)
                ->findByCompleteLoanSearch($search);
            $breadcrumbArray = array(
                array('Dashboard' , 'dashboard', ''),
                array('Loan' , 'loan', ''),
                array('Complete' , '', ''),
            );
        }
        else {
            $loans = $this->getDoctrine()
                ->getRepository(Loan::class)
                ->findBy(array(
                    'isComplete'=>1
                ));
            $breadcrumbArray = array(
                array('Dashboard' , 'dashboard', ''),
                array('Loan' , 'loan', ''),
                array('Complete' , '', ''),
            );
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $loans, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            7/*limit per page*/
        );

        return $this->render('loan/loanComplete.html.twig', array(
            'loans'=>$pagination,
            'breadcrumbArray'=>$breadcrumbArray,
        ));
    }
}