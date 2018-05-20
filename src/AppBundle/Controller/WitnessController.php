<?php
/**
 * Created by PhpStorm.
 * User: mihiran-hlrm
 * Date: 5/3/18
 * Time: 2:22 PM
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\WitnessType;
use AppBundle\Entity\Witness;
use AppBundle\Entity\Loan;

class WitnessController extends BaseController
{
    /**
     * @Route("/dashboard/witness", name="witness")
     */
    public function Witness(Request $request)
    {
        $search = $request->get('search');
        $loanId = $request->get('loanId');

        if($search) {
            $witnesses = $this->getDoctrine()
                ->getRepository(Witness::class)
                ->findByWitnessSearch($search);
            $breadcrumbArray = array(
                array('Dashboard' , 'dashboard', ''),
                array('witness' , '', ''),
            );
        }
        elseif ($loanId) {
            $loan = $this->getDoctrine()
                ->getRepository(Loan::class)
                ->find($loanId);
            $witnesses = $loan->getWitnesses();
            $breadcrumbArray = array(
                array('Dashboard' , 'dashboard', ''),
                array('Loan' , 'loan', ''),
                array($loan->getLoanCode() , 'loanView', $loanId),
                array('witness' , '', ''),
            );
        }
        else {
            $witnesses = $this->getDoctrine()
                ->getRepository(Witness::class)
                ->findAll();
            $breadcrumbArray = array(
                array('Dashboard' , 'dashboard', ''),
                array('witness' , '', ''),
            );
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $witnesses, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            7/*limit per page*/
        );

        return $this->render('witness/witness.html.twig', array(
            'witnesses'=>$pagination,
            'breadcrumbArray'=>$breadcrumbArray,
        ));
    }

    /**
     * @Route("/dashboard/witness/view/{id}", name="witnessView")
     */
    public function witnessView(Request $request, $id)
    {
        $witness = $this->getDoctrine()
            ->getRepository(Witness::class)
            ->find($id);

        if (!$witness) {
            throw $this->createNotFoundException(
                'No Witness Found !'
            );
        }

        $breadcrumbArray = array(
            array('Dashboard' , 'dashboard', ''),
            array('Witness' , 'witness', ''),
            array('View', '', ''),
            array($witness->getName() , '', ''),
        );

        return $this->render('witness/witnessView.html.twig', array(
            'witness'=>$witness,
            'breadcrumbArray'=>$breadcrumbArray,
        ));
    }

    /**
     * @Route("/dashboard/witness/edit/{id}", name="witnessEdit")
     */
    public function witnessEdit(Request $request, $id)
    {
        $witness = $this->getDoctrine()
            ->getRepository(Witness::class)
            ->find($id);

        if (!$witness) {
            throw $this->createNotFoundException(
                'No Witness Found !'
            );
        }

        $form = $this->createForm(new WitnessType(), $witness);

        $form->handleRequest($request);
        if ($form->isSubmitted() & $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($witness);
            $entityManager->flush();

            return $this->redirectToRoute('witnessEdit', array('id' => $witness->getId()));
        }

        $breadcrumbArray = array(
            array('Dashboard' , 'dashboard', ''),
            array('Witness' , 'witness', ''),
            array('Edit', '', ''),
            array($witness->getName() , '', ''),
        );

        return $this->render('witness/witnessEdit.html.twig', array(
            'form' => $form->createView(),
            'breadcrumbArray'=>$breadcrumbArray,
        ));
    }

    /**
     * @Route("/dashboard/witness/add", name="witnessAdd")
     */
    public function witnessAdd(Request $request)
    {
        $witness = new Witness();
        $form = $this->createForm(new WitnessType(), $witness);

        $form->handleRequest($request);
        if ($form->isSubmitted() & $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($witness);
            $entityManager->flush();

            return $this->redirectToRoute('witnessAdd');
        }

        $breadcrumbArray = array(
            array('Dashboard' , 'dashboard', ''),
            array('Witness' , 'witness', ''),
            array('Add', '', ''),
        );

        return $this->render('witness/witnessAdd.html.twig', array(
            'form' => $form->createView(),
            'breadcrumbArray'=>$breadcrumbArray,
        ));
    }
}