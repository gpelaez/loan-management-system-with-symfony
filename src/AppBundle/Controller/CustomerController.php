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
use AppBundle\Form\CustomerType;
use AppBundle\Entity\Customer;

class CustomerController extends BaseController
{
    /**
     * @Route("/dashboard/customer", name="customer")
     */
    public function Customer(Request $request)
    {
        $search = $request->get('search');

        if($search) {
            $customers = $this->getDoctrine()
                ->getRepository(Customer::class)
                ->findByCustomerSearch($search);
            $breadcrumbArray = array(
                array('Dashboard' , 'dashboard', ''),
                array('Customer' , '', ''),
            );
        } else {
            $customers = $this->getDoctrine()
                ->getRepository(Customer::class)
                ->findAll();
            $breadcrumbArray = array(
                array('Dashboard' , 'dashboard', ''),
                array('Customer' , '', ''),
            );
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $customers, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            7/*limit per page*/
        );

        return $this->render('customer/customer.html.twig', array(
            'customers'=>$pagination,
            'breadcrumbArray'=>$breadcrumbArray,
        ));
    }

    /**
     * @Route("/dashboard/customer/view/{id}", name="customerView")
     */
    public function customerView(Request $request, $id)
    {
        $customer = $this->getDoctrine()
            ->getRepository(Customer::class)
            ->find($id);

        if (!$customer) {
            throw $this->createNotFoundException(
                'No Customer Found !'
            );
        }

        $breadcrumbArray = array(
            array('Dashboard' , 'dashboard', ''),
            array('Customer' , 'customer', ''),
            array('View', '', ''),
            array($customer->getName() , '', ''),
        );

        return $this->render('customer/customerView.html.twig', array(
            'customer'=>$customer,
            'breadcrumbArray'=>$breadcrumbArray,
        ));
    }

    /**
     * @Route("/dashboard/customer/edit/{id}", name="customerEdit")
     */
    public function customerEdit(Request $request, $id)
    {
        $customer = $this->getDoctrine()
            ->getRepository(Customer::class)
            ->find($id);

        if (!$customer) {
            throw $this->createNotFoundException(
                'No Customer Found !'
            );
        }

        $form = $this->createForm(new CustomerType(), $customer);

        $form->handleRequest($request);
        if ($form->isSubmitted() & $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($customer);
            $entityManager->flush();

            return $this->redirectToRoute('customerEdit', array('id' => $customer->getId()));
        }

        $breadcrumbArray = array(
            array('Dashboard' , 'dashboard', ''),
            array('Customer' , 'customer', ''),
            array('Edit', '', ''),
            array($customer->getName() , '', ''),
        );

        return $this->render('customer/customerEdit.html.twig', array(
            'form' => $form->createView(),
            'breadcrumbArray'=>$breadcrumbArray,
        ));
    }

    /**
     * @Route("/dashboard/customer/add", name="customerAdd")
     */
    public function customerAdd(Request $request)
    {
        $customer = new Customer();
        $form = $this->createForm(new CustomerType(), $customer);

        $form->handleRequest($request);
        if ($form->isSubmitted() & $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($customer);
            $entityManager->flush();

            return $this->redirectToRoute('customerAdd');
        }

        $breadcrumbArray = array(
            array('Dashboard' , 'dashboard', ''),
            array('Customer' , 'customer', ''),
            array('Add', '', ''),
        );

        return $this->render('customer/customerAdd.html.twig', array(
            'form' => $form->createView(),
            'breadcrumbArray'=>$breadcrumbArray,
        ));
    }
}