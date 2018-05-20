<?php
/**
 * Created by PhpStorm.
 * User: mihiran-hlrm
 * Date: 5/1/18
 * Time: 7:10 PM
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');

        $isRoleAdmin = $auth_checker->isGranted('ROLE_ADMIN');
        if ($isRoleAdmin) {
            return $this->redirect(
                $this->generateUrl("dashboard")
            );
        }

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction(Request $request)
    {
        return;
    }
}