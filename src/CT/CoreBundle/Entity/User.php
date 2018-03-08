<?php

namespace CT\CoreBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;


/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{



    /**
     * @var int
     *
     * @ORM\Column(name="virtual_money_balance", type="integer")
     */
    protected $virtualMoneyBalance;



    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


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
     * Set virtualMoneyBalance
     *
     * @param integer $virtualMoneyBalance
     *
     * @return User
     */
    public function setVirtualMoneyBalance($virtualMoneyBalance)
    {
        $this->price = $virtualMoneyBalance;

        return $this;
    }

    /**
     * Get virtualMoneyBalance
     *
     * @return int
     */
    public function getVirtualMoneyBalance()
    {
        return $this->virtualMoneyBalance;
    }
}

