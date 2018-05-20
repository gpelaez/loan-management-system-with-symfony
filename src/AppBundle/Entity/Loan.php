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
 * @ORM\Entity(repositoryClass="AppBundle\Entity\LoanRepository")
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
     * Many Loans have One Customer.
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="loans")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    private $customer;

    /**
     * One Loan has Many Installments.
     * @ORM\OneToMany(targetEntity="Installment", mappedBy="loan")
     */
    private $installments;

    /**
     * Many Loans have Many Witnesses.
     * @ORM\ManyToMany(targetEntity="Witness", mappedBy="loans")
     */
    private $witnesses;

    public function __construct() {
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
    public function setCustomer(\AppBundle\Entity\Customer $customer = null)
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
    public function addInstallment(\AppBundle\Entity\Installment $installment)
    {
        $this->installments[] = $installment;

        return $this;
    }

    /**
     * Remove installment
     *
     * @param \AppBundle\Entity\Installment $installment
     */
    public function removeInstallment(\AppBundle\Entity\Installment $installment)
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
    public function addWitness(\AppBundle\Entity\Witness $witness = null)
    {
        $this->witnesses[] = $witness;

        return $this;
    }

    /**
     * Remove witness
     *
     * @param \AppBundle\Entity\Witness $witness
     */
    public function removeWitness(\AppBundle\Entity\Witness $witness)
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
}
