<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Loan
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LoanRepository")
 * @UniqueEntity("loanCode")
 */
class Loan
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateTime", type="datetime")
     */
    private $dateTime;

    /**
     * @var float
     *
     * @ORM\Column(name="LoanAmount", type="float")
     * @Assert\NotBlank()
     */
    private $loanAmount;

    /**
     * @var string
     *
     * @ORM\Column(name="LoanCode", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $loanCode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="StartedDate", type="datetime")
     */
    private $startedDate;

    /**
     * @var float
     *
     * @ORM\Column(name="Interest", type="float")
     */
    private $interest;

    /**
     * @var integer
     *
     * @ORM\Column(name="Period", type="integer")
     */
    private $period;

    /**
     * @var integer
     *
     * @ORM\Column(name="isComplete", type="integer")
     */
    private $isComplete;

    /**
     * @var float
     */
    private $totalAmount;

    /**
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * @param $totalAmount
     * @return $this
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    /**
     * @var float
     */
    private $weeklyPayment;

    /**
     * @return float
     */
    public function getWeeklyPayment()
    {
        return $this->weeklyPayment;
    }

    /**
     * @param $weeklyPayment
     * @return $this
     */
    public function setWeeklyPayment($weeklyPayment)
    {
        $this->weeklyPayment = $weeklyPayment;

        return $this;
    }

    /**
     * @var float
     */
    private $totalPayment;

    /**
     * @return float
     */
    public function getTotalPayment()
    {
        return $this->totalPayment;
    }

    /**
     * @param $totalPayment
     * @return $this
     */
    public function setTotalPayment($totalPayment)
    {
        $this->totalPayment = $totalPayment;

        return $this;
    }

    /**
     * @var float
     */
    private $totalPaymentDates;

    /**
     * @return float
     */
    public function getTotalPaymentDates()
    {
        return $this->totalPaymentDates;
    }

    /**
     * @param $totalPaymentDates
     * @return $this
     */
    public function setTotalPaymentDates($totalPaymentDates)
    {
        $this->totalPaymentDates = $totalPaymentDates;

        return $this;
    }

    /**
     * @var float
     */
    private $areasAmount;

    /**
     * @return float
     */
    public function getAreasAmount()
    {
        return $this->areasAmount;
    }

    /**
     * @param $areasAmount
     * @return $this
     */
    public function setAreasAmount($areasAmount)
    {
        $this->areasAmount = $areasAmount;

        return $this;
    }

    /**
     * @var float
     */
    private $areasAmountDates;

    /**
     * @return float
     */
    public function getAreasAmountDates()
    {
        return $this->areasAmountDates;
    }

    /**
     * @param $areasAmountDates
     * @return $this
     */
    public function setAreasAmountDates($areasAmountDates)
    {
        $this->areasAmountDates = $areasAmountDates;

        return $this;
    }

    /**
     * @var float
     */
    private $lastInstallmentAmount;

    /**
     * @return float
     */
    public function getLastInstallmentAmount()
    {
        return $this->lastInstallmentAmount;
    }

    /**
     * @param $lastInstallmentAmount
     * @return $this
     */
    public function setLastInstallmentAmount($lastInstallmentAmount)
    {
        $this->lastInstallmentAmount = $lastInstallmentAmount;

        return $this;
    }

    /**
     * @var float
     */
    private $lastInstallmentAmountDates;

    /**
     * @return float
     */
    public function getLastInstallmentAmountDates()
    {
        return $this->lastInstallmentAmountDates;
    }

    /**
     * @param $lastInstallmentAmountDates
     * @return $this
     */
    public function setLastInstallmentAmountDates($lastInstallmentAmountDates)
    {
        $this->lastInstallmentAmountDates = $lastInstallmentAmountDates;

        return $this;
    }

    /**
     * Many Loans have One Area.
     * @ORM\ManyToOne(targetEntity="Area", inversedBy="loans")
     * @ORM\JoinColumn(name="area_id", referencedColumnName="id")
     */
    private $area;

    /**
     * Many Loans have One Customer.
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="loans")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    private $customer;

    /**
     * One Loan has Many Installments.
     * @ORM\OneToMany(targetEntity="Installment", mappedBy="loan", cascade={"remove"}, orphanRemoval=true)
     */
    private $installments;

    /**
     * Many Loans have Many Witnesses.
     * @ORM\ManyToMany(targetEntity="Witness", inversedBy="loans")
     * @ORM\JoinTable(name="loans_witnesses")
     */
    private $witnesses;

    /**
     * Loan constructor.
     */
    public function __construct()
    {
        $this->setDateTime(new \DateTime());
        $this->setStartedDate(new \DateTime());
        $this->setIsComplete(0);
        $this->installments = new ArrayCollection();
        $this->witnesses = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getLoanCode();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateTime
     *
     * @param \DateTime $dateTime
     *
     * @return Loan
     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    /**
     * Get dateTime
     *
     * @return \DateTime
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * Set loanAmount
     *
     * @param float $loanAmount
     *
     * @return Loan
     */
    public function setLoanAmount($loanAmount)
    {
        $this->loanAmount = $loanAmount;

        return $this;
    }

    /**
     * Get loanAmount
     *
     * @return float
     */
    public function getLoanAmount()
    {
        return $this->loanAmount;
    }

    /**
     * Set loanCode
     *
     * @param string $loanCode
     *
     * @return Loan
     */
    public function setLoanCode($loanCode)
    {
        $this->loanCode = $loanCode;

        return $this;
    }

    /**
     * Get loanCode
     *
     * @return string
     */
    public function getLoanCode()
    {
        return $this->loanCode;
    }

    /**
     * Set startedDate
     *
     * @param \DateTime $startedDate
     *
     * @return Loan
     */
    public function setStartedDate($startedDate)
    {
        $this->startedDate = $startedDate;

        return $this;
    }

    /**
     * Get startedDate
     *
     * @return \DateTime
     */
    public function getStartedDate()
    {
        return $this->startedDate;
    }

    /**
     * Set interest
     *
     * @param float $interest
     *
     * @return Loan
     */
    public function setInterest($interest)
    {
        $this->interest = $interest;

        return $this;
    }

    /**
     * Get interest
     *
     * @return float
     */
    public function getInterest()
    {
        return $this->interest;
    }

    /**
     * Set period
     *
     * @param integer $period
     *
     * @return Loan
     */
    public function setPeriod($period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Get period
     *
     * @return integer
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * Set isComplete
     *
     * @param integer $isComplete
     *
     * @return Loan
     */
    public function setIsComplete($isComplete)
    {
        $this->isComplete = $isComplete;

        return $this;
    }

    /**
     * Get isComplete
     *
     * @return integer
     */
    public function getIsComplete()
    {
        return $this->isComplete;
    }

    /**
     * Set customer
     *
     * @param \AppBundle\Entity\Customer $customer
     *
     * @return Loan
     */
    public function setCustomer(Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \AppBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Add installment
     *
     * @param \AppBundle\Entity\Installment $installment
     *
     * @return Loan
     */
    public function addInstallment(Installment $installment)
    {
        $this->installments[] = $installment;

        return $this;
    }

    /**
     * Remove installment
     *
     * @param \AppBundle\Entity\Installment $installment
     */
    public function removeInstallment(Installment $installment)
    {
        $this->installments->removeElement($installment);
    }

    /**
     * Get installments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInstallments()
    {
        return $this->installments;
    }

    /**
     * Add witness
     *
     * @param \AppBundle\Entity\Witness $witness
     *
     * @return Loan
     */
    public function addWitness(Witness $witness = null)
    {
        $this->witnesses[] = $witness;

        return $this;
    }

    /**
     * Remove witness
     *
     * @param \AppBundle\Entity\Witness $witness
     */
    public function removeWitness(Witness $witness)
    {
        $this->witnesses->removeElement($witness);
    }

    /**
     * Get witnesses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWitnesses()
    {
        return $this->witnesses;
    }

    /**
     * @param Witness|null $witness
     * @return $this
     */
    public function setFirstWitness(Witness $witness = null)
    {
        $this->witnesses[0] = $witness;

        return $this;
    }

    /**
     * @param Witness|null $witness
     * @return $this
     */
    public function setSecondWitness(Witness $witness = null)
    {
        $this->witnesses[1] = $witness;

        return $this;
    }

    /**
     * Set area
     *
     * @param \AppBundle\Entity\Area $area
     *
     * @return Loan
     */
    public function setArea(Area $area = null)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return \AppBundle\Entity\Area
     */
    public function getArea()
    {
        return $this->area;
    }
}
