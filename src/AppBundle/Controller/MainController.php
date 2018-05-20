<?php
/**
 * Created by PhpStorm.
 * User: mihiran-hlrm
 * Date: 5/1/18
 * Time: 10:34 AM
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends BaseController
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage(Request $request)
    {
        return $this->redirect(
            $this->generateUrl("login")
        );
    }

    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard(Request $request)
    {
        $breadcrumbArray = array(
            array('Dashboard' , 'dashboard', ''),
        );

        return $this->render('dashboard/dashboard.html.twig', array(
            'breadcrumbArray'=>$breadcrumbArray,
        ));
    }
}