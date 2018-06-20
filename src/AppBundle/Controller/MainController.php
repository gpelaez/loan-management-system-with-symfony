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
use AppBundle\Entity\Area;
use AppBundle\Entity\Loan;

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
        $totalArray = array();

        $areas = $this->getDoctrine()
            ->getRepository(Area::class)
            ->findAll();

        foreach ($areas as $area) {

            $loans = $this->getDoctrine()
                ->getRepository(Loan::class)
                ->findLoansByAreaId($area->getId());

            $totalLoanAmount = 0;
            $totalTotalPayment = 0;
            $totalLastInstallmentAmount = 0;

            foreach ($loans as $loan) {
                $this->updateLoanByCalculations($loan);

                $totalLoanAmount += $loan->getLoanAmount();
                $totalTotalPayment += $loan->getTotalPayment();
                $totalLastInstallmentAmount += $loan->getLastInstallmentAmount();
            }

            $totalArray[$area->getId()] = array($totalLoanAmount, $totalTotalPayment, $totalLastInstallmentAmount);
        }

        return $this->render('dashboard/dashboard.html.twig', array(
            'areas' => $areas,
            'total' => $totalArray,
        ));
    }
}