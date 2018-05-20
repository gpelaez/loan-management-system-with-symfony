<?php
/**
 * Created by PhpStorm.
 * User: mihiran-hlrm
 * Date: 5/3/18
 * Time: 2:23 PM
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\InstallmentType;
use AppBundle\Entity\Installment;
use AppBundle\Entity\Loan;

class InstallmentController extends BaseController
{
    /**
     * @Route("/dashboard/installment", name="installment")
     */
    public function Installment(Request $request)
    {
        $search = $request->get('search');
        $loanId = $request->get('loanId');

        if($search) {
            $installments = $this->getDoctrine()
                ->getRepository(Installment::class)
                ->findByInstallmentSearch($search);
            $breadcrumbArray = array(
                array('Dashboard' , 'dashboard', ''),
                array('Installment' , '', ''),
            );
        }
        elseif ($loanId) {
            $loan = $this->getDoctrine()
                ->getRepository(Loan::class)
                ->find($loanId);
            $installments = $loan->getInstallments();
            $breadcrumbArray = array(
                array('Dashboard' , 'dashboard', ''),
                array('Loan' , 'loan', ''),
                array($loan->getLoanCode() , 'loanView', $loanId),
                array('Installment' , '', ''),
            );
        }
        else {
            $installments = $this->getDoctrine()
                ->getRepository(Installment::class)
                ->findAll();
            $breadcrumbArray = array(
                array('Dashboard' , 'dashboard', ''),
                array('Installment' , '', ''),
            );
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $installments, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            7/*limit per page*/
        );

        return $this->render('installment/installment.html.twig', array(
            'installments'=>$pagination,
            'breadcrumbArray'=>$breadcrumbArray,
        ));
    }

    /**
     * @Route("/dashboard/installment/view/{id}", name="installmentView")
     */
    public function installmentView(Request $request, $id)
    {
        $installment = $this->getDoctrine()
            ->getRepository(Installment::class)
            ->find($id);

        if (!$installment) {
            throw $this->createNotFoundException(
                'No Installment Found !'
            );
        }

        $breadcrumbArray = array(
            array('Dashboard' , 'dashboard', ''),
            array('Installment' , 'installment', ''),
            array('View', '', ''),
            array($installment->getPaymentDate()->format('Y-m-d') , '', ''),
        );

        return $this->render('installment/installmentView.html.twig', array(
            'installment'=>$installment,
            'breadcrumbArray'=>$breadcrumbArray,
        ));
    }

    /**
     * @Route("/dashboard/installment/edit/{id}", name="installmentEdit")
     */
    public function installmentEdit(Request $request, $id)
    {
        $installment = $this->getDoctrine()
            ->getRepository(Installment::class)
            ->find($id);

        if (!$installment) {
            throw $this->createNotFoundException(
                'No Installment Found !'
            );
        }

        $form = $this->createForm(new InstallmentType(), $installment);

        $form->handleRequest($request);
        if ($form->isSubmitted() & $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($installment);
            $entityManager->flush();

            return $this->redirectToRoute('installmentEdit', array('id' => $installment->getId()));
        }

        $breadcrumbArray = array(
            array('Dashboard' , 'dashboard', ''),
            array('Installment' , 'installment', ''),
            array('Edit', '', ''),
            array($installment->getPaymentDate()->format('Y-m-d') , '', ''),
        );

        return $this->render('installment/installmentEdit.html.twig', array(
            'form' => $form->createView(),
            'breadcrumbArray'=>$breadcrumbArray,
        ));
    }

    /**
     * @Route("/dashboard/installment/add", name="installmentAdd")
     */
    public function installmentAdd(Request $request)
    {
        $installment = new Installment();
        $form = $this->createForm(new InstallmentType(), $installment);

        $form->handleRequest($request);
        if ($form->isSubmitted() & $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($installment);
            $entityManager->flush();

            return $this->redirectToRoute('installmentAdd');
        }

        $breadcrumbArray = array(
            array('Dashboard' , 'dashboard', ''),
            array('Installment' , 'installment', ''),
            array('Add', '', ''),
        );

        return $this->render('installment/installmentAdd.html.twig', array(
            'form' => $form->createView(),
            'breadcrumbArray'=>$breadcrumbArray,
        ));
    }
}