<?php

namespace CT\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Application
 *
 * @ORM\Table(name="application")
 * @ORM\Entity(repositoryClass="CT\CoreBundle\Repository\ApplicationRepository")
 */
class Application
{


    /**
     * @var string
     *
     * @ORM\Column(name="State", type="string", length=255)
     */
    private $state;


    /**
     * @ORM\ManyToOne(targetEntity="CT\CoreBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;



    /**
     * @ORM\ManyToOne(targetEntity="CT\CoreBundle\Entity\Shift",inversedBy="applications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $shift;


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="CreatedAt", type="datetime")
     */
    private $createdAt;


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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Application
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set user
     *
     * @param \CT\CoreBundle\Entity\User $user
     *
     * @return Application
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

    /**
     * Set shift
     *
     * @param \CT\CoreBundle\Entity\Shift $shift
     *
     * @return Application
     */
    public function setShift(\CT\CoreBundle\Entity\Shift $shift)
    {
        $this->shift = $shift;

        return $this;
    }

    /**
     * Get shift
     *
     * @return \CT\CoreBundle\Entity\Shift
     */
    public function getShift()
    {
        return $this->shift;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return Application
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }
}
