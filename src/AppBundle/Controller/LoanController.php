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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use AppBundle\Entity\Area;
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
            $this->updateLoanByCalculations($loan);
        }

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $loans, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('loan/loan.html.twig', array(
            'areaId' => $areaId,
            'loans' => $pagination,
        ));
    }

    /**
     * @Route("/dashboard/area/{areaId}/loan/print", name="loanPrint")
     */
    public function loanPrint(Request $request, $areaId)
    {
        $loans = $this->getDoctrine()
            ->getRepository(Loan::class)
            ->findLoansByAreaId($areaId);

        foreach ($loans as $loan) {
            $this->updateLoanByCalculations($loan);
        }

        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('Mihiran-Hlrm')
            ->setLastModifiedBy('Mihiran-Hlrm')
            ->setTitle('Micro-Credit Loans')
            ->setSubject('Micro-Credit Loans')
            ->setDescription('Micro-Credit Loans')
            ->setKeywords('office 2007 openxml php')
            ->setCategory('Loans');

        // Add some data
        $spreadsheet->getSheet(0)
            ->setCellValue('A1', '#')
            ->setCellValue('B1', 'Loan Code')
            ->setCellValue('C1', 'Customer Name')
            ->setCellValue('D1', 'Customer Nic')
            ->setCellValue('E1', 'Loan Amount')
            ->setCellValue('F1', 'Started Date')
            ->setCellValue('G1', 'Weekly Payment')
            ->setCellValue('H1', 'Total Payment')
            ->setCellValue('I1', 'Areas Amount')
            ->setCellValue('J1', 'Last Installment')
            ->setCellValue('K1', 'Period');

        $spreadsheet->createSheet();
        $spreadsheet->getSheet(1)
            ->setCellValue('A1', '#')
            ->setCellValue('B1', 'Loan Code')
            ->setCellValue('C1', 'Customer Name')
            ->setCellValue('D1', 'Loan Amount')
            ->setCellValue('E1', 'Areas Amount')
            ->setCellValue('F1', 'Mobile')
            ->setCellValue('G1', 'TUE')
            ->setCellValue('H1', 'WED')
            ->setCellValue('I1', 'THU')
            ->setCellValue('J1', 'FRI')
            ->setCellValue('K1', 'SAT')
            ->setCellValue('L1', 'SUN')
            ->setCellValue('M1', 'MON');

        $row = 3;
        $totalLoanAmount = 0;
        $totalTotalPayment = 0;
        $totalLastInstallmentAmount = 0;

        foreach ($loans as $key => $loan) {
            $this->updateLoanByCalculations($loan);

            $row = $key + 3;

            $spreadsheet->getSheet(0)
                ->setCellValue('A' . $row, $key + 1)
                ->setCellValue('B' . $row, $loan->getLoanCode())
                ->setCellValue('C' . $row, $loan->getCustomer()->getName())
                ->setCellValue('D' . $row, $loan->getCustomer()->getNic())
                ->setCellValue('E' . $row, $loan->getLoanAmount())
                ->setCellValue('F' . $row, $loan->getStartedDate()->format('Y-m-d'))
                ->setCellValue('G' . $row, $loan->getWeeklyPayment())
                ->setCellValue('H' . $row, $loan->getTotalPayment() . ' (' . $loan->getTotalPaymentDates() . ')')
                ->setCellValue('I' . $row, $loan->getAreasAmount() . ' (' . $loan->getAreasAmountDates() . ')')
                ->setCellValue('J' . $row, $loan->getLastInstallmentAmount() . ' (' . $loan->getLastInstallmentAmountDates() . ')')
                ->setCellValue('K' . $row, $loan->getPeriod());

            $totalLoanAmount += $loan->getLoanAmount();
            $totalTotalPayment += $loan->getTotalPayment();
            $totalLastInstallmentAmount += $loan->getLastInstallmentAmount();

            $spreadsheet->getSheet(1)
                ->setCellValue('A' . $row, $key + 1)
                ->setCellValue('B' . $row, $loan->getLoanCode())
                ->setCellValue('C' . $row, $loan->getCustomer()->getName())
                ->setCellValue('D' . $row, $loan->getLoanAmount())
                ->setCellValue('E' . $row, $loan->getAreasAmount())
                ->setCellValue('F' . $row, $loan->getCustomer()->getMobile());
        }

        $spreadsheet->getSheet(0)
            ->setCellValue('E' . ($row + 1), $totalLoanAmount)
            ->setCellValue('H' . ($row + 1), $totalTotalPayment)
            ->setCellValue('J' . ($row + 1), $totalLastInstallmentAmount);

        $spreadsheet->getSheet(0)->getStyle('A1:K1000')
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $spreadsheet->getSheet(1)->getStyle('A1:M1000')
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Rename worksheet
        $spreadsheet->getSheet(0)->setTitle('Micro-Credit Detail-Report');

        // Rename worksheet
        $spreadsheet->getSheet(1)->setTitle('Micro-Credit Collection-Sheet');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        $date = new \DateTime();
        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Micro-Credit-Loans-Area-' . $areaId . '-' . $date->format('Y-m-d') . '.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');

        return $this->redirectToRoute('loan', array(
            'areaId' => $areaId,
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

        $loan = $this->updateLoanByCalculations($loan);

        if ($loan->getTotalPayment() >= $loan->getTotalAmount()) {
            $loan->setIsComplete(1);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($loan);
            $entityManager->flush();
        }

        $data = array(
            'totalPayment' => $loan->getTotalPayment(),
            'totalPaymentDates' => $loan->getTotalPaymentDates(),
            'areasAmount' => $loan->getAreasAmount(),
            'areasAmountDates' => $loan->getAreasAmountDates(),
            'lastInstallmentAmount' => $loan->getLastInstallmentAmount(),
        );

        return new JsonResponse($data);
    }

    /**
     * @Route("/dashboard/area/{areaId}/loan/{loanId}/remove-installment/{installmentId}", name="removeInstallment")
     */
    public function removeInstallment(Request $request, $areaId, $loanId, $installmentId)
    {
        $loan = $this->getDoctrine()
            ->getRepository(Loan::class)
            ->find($loanId);

        if (!$loan) {
            throw $this->createNotFoundException(
                'No Loan Found !'
            );
        }

        $installment = $this->getDoctrine()
            ->getRepository(Installment::class)
            ->find($installmentId);

        if (!$installment) {
            throw $this->createNotFoundException(
                'No Installment Found !'
            );
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($installment);
        $entityManager->flush();

        $loan = $this->updateLoanByCalculations($loan);

        if ($loan->getTotalPayment() >= $loan->getTotalAmount()) {
            $loan->setIsComplete(1);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($loan);
            $entityManager->flush();
        }

        return $this->redirectToRoute('loanView', array(
            'areaId' => $areaId,
            'loanId' => $loanId,
        ));
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

        $loan = $this->updateLoanByCalculations($loan);

        return $this->render('loan/loanView.html.twig', array(
            'areaId' => $areaId,
            'loanId' => $loanId,
            'loan' => $loan,
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

            return $this->redirectToRoute('loan', array(
                'areaId' => $areaId,
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
            'areaId' => $areaId,
            'loanId' => $loanId,

            'customerName' => $customerName,
            'customerNic' => $customerNic,
            'customerAddress' => $customerAddress,
            'customerMobile' => $customerMobile,
            'customerFixed' => $customerFixed,

            'loanAmount' => $loanAmount,
            'loanCode' => $loanCode,
            'loanStartedDate' => $loanStartedDate,
            'loanInterest' => $loanInterest,
            'loanPeriod' => $loanPeriod,
            'loanIsComplete' => $loanIsComplete,

            'witness1Name' => $witness1Name,
            'witness1Nic' => $witness1Nic,
            'witness1Address' => $witness1Address,
            'witness1Mobile' => $witness1Mobile,
            'witness1Fixed' => $witness1Fixed,

            'witness2Name' => $witness2Name,
            'witness2Nic' => $witness2Nic,
            'witness2Address' => $witness2Address,
            'witness2Mobile' => $witness2Mobile,
            'witness2Fixed' => $witness2Fixed,
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
//            $loanCode = $request->get('loanCode');
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
            } else {
                foreach ($customer->getLoans() as $loan) {
                    if (!$loan->getIsComplete()) {
                        return $this->render('loan/loanAdd.html.twig', array(
                            'areaId' => $areaId,
                            'error' => $customerName . " has an Incomplete Loan !",
                            'errorLoan' => "Loan Code: " . $loan->getLoanCode() . " | Loan Amount: " . $loan->getLoanAmount(),
                        ));
                    }
                }
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
            $loan->setLoanCode('loanCode');
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

            $loanId = $loan->getId();
            if ($loanId < 10) {
                $loan->setLoanCode('MT00000' . $loanId);
            } elseif ($loanId < 100) {
                $loan->setLoanCode('MT0000' . $loanId);
            } elseif ($loanId < 1000) {
                $loan->setLoanCode('MT000' . $loanId);
            } else {
                $loan->setLoanCode('MT00' . $loanId);
            }
            $entityManager->persist($loan);
            $entityManager->flush();

            return $this->redirectToRoute('loanAdd', array(
                'areaId' => $areaId,
            ));
        }

        return $this->render('loan/loanAdd.html.twig', array(
            'areaId' => $areaId,
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
            $this->updateLoanByCalculations($loan);
        }

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $loans, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('loan/loanComplete.html.twig', array(
            'areaId' => $areaId,
            'loans' => $pagination,
        ));
    }
}