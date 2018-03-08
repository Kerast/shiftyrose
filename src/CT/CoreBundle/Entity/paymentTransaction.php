<?php

namespace CT\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * paymentTransaction
 *
 * @ORM\Table(name="payment_transaction")
 * @ORM\Entity(repositoryClass="CT\CoreBundle\Repository\paymentTransactionRepository")
 */
class paymentTransaction
{

    /**
     * @ORM\ManyToOne(targetEntity="CT\CoreBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="itemName", type="string", length=255)
     */
    private $itemName;

    /**
     * @var int
     *
     * @ORM\Column(name="itemNumber", type="integer")
     */
    private $itemNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="paymentStatus", type="string", length=255)
     */
    private $paymentStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="mcGross", type="string", length=255)
     */
    private $mcGross;

    /**
     * @var string
     *
     * @ORM\Column(name="paypalTransactionId", type="string", length=255)
     */
    private $paypalTransactionId;

    /**
     * @var string
     *
     * @ORM\Column(name="payerEmail", type="string", length=255)
     */
    private $payerEmail;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set itemName
     *
     * @param string $itemName
     *
     * @return paymentTransaction
     */
    public function setItemName($itemName)
    {
        $this->itemName = $itemName;

        return $this;
    }

    /**
     * Get itemName
     *
     * @return string
     */
    public function getItemName()
    {
        return $this->itemName;
    }

    /**
     * Set itemNumber
     *
     * @param integer $itemNumber
     *
     * @return paymentTransaction
     */
    public function setItemNumber($itemNumber)
    {
        $this->itemNumber = $itemNumber;

        return $this;
    }

    /**
     * Get itemNumber
     *
     * @return int
     */
    public function getItemNumber()
    {
        return $this->itemNumber;
    }

    /**
     * Set paymentStatus
     *
     * @param string $paymentStatus
     *
     * @return paymentTransaction
     */
    public function setPaymentStatus($paymentStatus)
    {
        $this->paymentStatus = $paymentStatus;

        return $this;
    }

    /**
     * Get paymentStatus
     *
     * @return string
     */
    public function getPaymentStatus()
    {
        return $this->paymentStatus;
    }

    /**
     * Set mcGross
     *
     * @param string $mcGross
     *
     * @return paymentTransaction
     */
    public function setMcGross($mcGross)
    {
        $this->mcGross = $mcGross;

        return $this;
    }

    /**
     * Get mcGross
     *
     * @return string
     */
    public function getMcGross()
    {
        return $this->mcGross;
    }

    /**
     * Set paypalTransactionId
     *
     * @param string $paypalTransactionId
     *
     * @return paymentTransaction
     */
    public function setPaypalTransactionId($paypalTransactionId)
    {
        $this->paypalTransactionId = $paypalTransactionId;

        return $this;
    }

    /**
     * Get paypalTransactionId
     *
     * @return string
     */
    public function getPaypalTransactionId()
    {
        return $this->paypalTransactionId;
    }

    /**
     * Set payerEmail
     *
     * @param string $payerEmail
     *
     * @return paymentTransaction
     */
    public function setPayerEmail($payerEmail)
    {
        $this->payerEmail = $payerEmail;

        return $this;
    }

    /**
     * Get payerEmail
     *
     * @return string
     */
    public function getPayerEmail()
    {
        return $this->payerEmail;
    }

    /**
     * Set user
     *
     * @param \CT\CoreBundle\Entity\User $user
     *
     * @return paymentTransaction
     */
    public function setUser(\CT\CoreBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \CT\CoreBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
