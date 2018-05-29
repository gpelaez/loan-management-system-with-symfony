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
use AppBundle\Entity\Admin;
use AppBundle\Entity\ChangePassword;
use AppBundle\Form\ChangePasswordType;

class AdminController extends BaseController
{
    /**
     * @Route("/dashboard/admin/change-password/{adminId}", name="adminChangePassword")
     */
    public function adminChangePassword(Request $request, $adminId)
    {
        $admin = $this->getDoctrine()
            ->getRepository(Admin::class)
            ->find($adminId);

        if (!$admin) {
            throw $this->createNotFoundException(
                'No Admin Found !'
            );
        }

        $changePasswordModel = new ChangePassword();
        $form = $this->createForm(ChangePasswordType::class, $changePasswordModel);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $admin->setPassword($changePasswordModel->getNewPassword());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($admin);
            $entityManager->flush();

            return $this->redirectToRoute('adminChangePassword', array(
                'adminId' => $adminId,
            ));
        }

        return $this->render('admin/adminChangePassword.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}