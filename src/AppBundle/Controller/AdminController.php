<?php
/**
 * Created by PhpStorm.
 * User: mihiran-hlrm
 * Date: 5/10/18
 * Time: 12:39 PM
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\AdminType;
use AppBundle\Entity\Admin;
use AppBundle\Entity\ChangePassword;
use AppBundle\Form\ChangePasswordType;

class AdminController extends BaseController
{
    /**
     * @Route("/dashboard/admin", name="admin")
     */
    public function Admin(Request $request)
    {
        $search = $request->get('search');

        if ($search) {
            $admins = $this->getDoctrine()
                ->getRepository(Admin::class)
                ->findByAdminSearch($search);
            $breadcrumbArray = array(
                array('Dashboard', 'dashboard', ''),
                array('Admin', '', ''),
            );
        } else {
            $admins = $this->getDoctrine()
                ->getRepository(Admin::class)
                ->findAll();
            $breadcrumbArray = array(
                array('Dashboard', 'dashboard', ''),
                array('Admin', '', ''),
            );
        }

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $admins, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            7/*limit per page*/
        );

        return $this->render('admin/admin.html.twig', array(
            'admins' => $pagination,
            'breadcrumbArray' => $breadcrumbArray,
        ));
    }

    /**
     * @Route("/dashboard/admin/view/{id}", name="adminView")
     */
    public function AdminView(Request $request, $id)
    {
        $admin = $this->getDoctrine()
            ->getRepository(Admin::class)
            ->find($id);

        if (!$admin) {
            throw $this->createNotFoundException(
                'No Admin Found !'
            );
        }

        $breadcrumbArray = array(
            array('Dashboard', 'dashboard', ''),
            array('Admin', 'admin', ''),
            array('View', '', ''),
            array($admin->getName(), '', ''),
        );

        return $this->render('admin/adminView.html.twig', array(
            'admin' => $admin,
            'breadcrumbArray' => $breadcrumbArray,
        ));
    }

    /**
     * @Route("/dashboard/admin/edit/{id}", name="adminEdit")
     */
    public function AdminEdit(Request $request, $id)
    {
        $admin = $this->getDoctrine()
            ->getRepository(Admin::class)
            ->find($id);

        if (!$admin) {
            throw $this->createNotFoundException(
                'No Admin Found !'
            );
        }

        $changePasswordModel = new ChangePassword();
        $form = $this->createForm(new ChangePasswordType(), $changePasswordModel);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $admin->setPassword($changePasswordModel->getNewPassword());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($admin);
            $entityManager->flush();

            return $this->redirectToRoute('adminEdit', array('id' => $admin->getId()));
        }

        $breadcrumbArray = array(
            array('Dashboard', 'dashboard', ''),
            array('Admin', 'admin', ''),
            array('Edit', '', ''),
            array($admin->getName(), '', ''),
        );

        return $this->render('admin/adminEdit.html.twig', array(
            'form' => $form->createView(),
            'breadcrumbArray' => $breadcrumbArray,
        ));
    }

    /**
     * @Route("/dashboard/admin/add", name="adminAdd")
     */
    public function AdminAdd(Request $request)
    {
        $admin = new Admin();
        $form = $this->createForm(new AdminType(), $admin);

        $form->handleRequest($request);
        if ($form->isSubmitted() & $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($admin);
            $entityManager->flush();

            return $this->redirectToRoute('adminAdd');
        }

        $breadcrumbArray = array(
            array('Dashboard', 'dashboard', ''),
            array('Admin', 'admin', ''),
            array('Add', ''),
        );

        return $this->render('admin/adminAdd.html.twig', array(
            'form' => $form->createView(),
            'breadcrumbArray' => $breadcrumbArray,
        ));
    }
}