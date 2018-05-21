<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Installment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InstallmentRepository")
 */
class Installment
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
     * @ORM\Column(name="InstallmentAmount", type="float")
     * @Assert\NotBlank()
     */
    private $installmentAmount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="PaymentDate", type="datetime")
     */
    private $paymentDate;

    /**
     * Many Installments have One Loan.
     * @ORM\ManyToOne(targetEntity="Loan", inversedBy="installments")
     * @ORM\JoinColumn(name="loan_id", referencedColumnName="id")
     */
    private $loan;

    /**
     * Installment constructor.
     */
    public function __construct() {
        $this->setDateTime(new \DateTime());
        $this->setPaymentDate(new \DateTime());
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
     * @return Installment
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
     * Set installmentAmount
     *
     * @param float $installmentAmount
     *
     * @return Installment
     */
    public function setInstallmentAmount($installmentAmount)
    {
        $this->installmentAmount = $installmentAmount;

        return $this;
    }

    /**
     * Get installmentAmount
     *
     * @return float
     */
    public function getInstallmentAmount()
    {
        return $this->installmentAmount;
    }

    /**
     * Set paymentDate
     *
     * @param \DateTime $paymentDate
     *
     * @return Installment
     */
    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    /**
     * Get paymentDate
     *
     * @return \DateTime
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * Set loan
     *
     * @param \AppBundle\Entity\Loan $loan
     *
     * @return Installment
     */
    public function setLoan(Loan $loan = null)
    {
        $this->loan = $loan;

        return $this;
    }

    /**
     * Get loan
     *
     * @return \AppBundle\Entity\Loan
     */
    public function getLoan()
    {
        return $this->loan;
    }
}
