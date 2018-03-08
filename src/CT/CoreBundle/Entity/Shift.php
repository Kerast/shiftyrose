<?php

namespace CT\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Shift
 *
 * @ORM\Table(name="shift")
 * @ORM\Entity(repositoryClass="CT\CoreBundle\Repository\ShiftRepository")
 */
class Shift
{


    /**
     * @ORM\OneToMany(targetEntity="CT\CoreBundle\Entity\Application", mappedBy="shift",cascade={"persist", "remove"})
     */
    private $applications;


    /**
     * @ORM\ManyToOne(targetEntity="CT\CoreBundle\Entity\Department",inversedBy="shifts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $department;


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="DesiredCoverage", type="integer")
     */
    private $desiredCoverage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="StartsAt", type="datetime")
     */
    private $startsAt;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="EndsAt", type="datetime")
     */
    private $endsAt;

    /**
     * @var int
     *
     * @ORM\Column(name="Price", type="integer")
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="Promotion", type="integer")
     */
    private $promotion;


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
     * Set desiredCoverage
     *
     * @param integer $desiredCoverage
     *
     * @return Shift
     */
    public function setDesiredCoverage($desiredCoverage)
    {
        $this->desiredCoverage = $desiredCoverage;

        return $this;
    }

    /**
     * Get desiredCoverage
     *
     * @return int
     */
    public function getDesiredCoverage()
    {
        return $this->desiredCoverage;
    }

    /**
     * Set startsAt
     *
     * @param \DateTime $startsAt
     *
     * @return Shift
     */
    public function setStartsAt($startsAt)
    {
        $this->startsAt = $startsAt;

        return $this;
    }

    /**
     * Get startsAt
     *
     * @return \DateTime
     */
    public function getStartsAt()
    {
        return $this->startsAt;
    }

    /**
     * Set endsAt
     *
     * @param string $endsAt
     *
     * @return Shift
     */
    public function setEndsAt($endsAt)
    {
        $this->endsAt = $endsAt;

        return $this;
    }

    /**
     * Get endsAt
     *
     * @return string
     */
    public function getEndsAt()
    {
        return $this->endsAt;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Shift
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set promotion
     *
     * @param integer $promotion
     *
     * @return Shift
     */
    public function setPromotion($promotion)
    {
        $this->promotion = $promotion;

        return $this;
    }

    /**
     * Get promotion
     *
     * @return int
     */
    public function getPromotion()
    {
        return $this->promotion;
    }

    /**
     * Set department
     *
     * @param \CT\CoreBundle\Entity\Department $department
     *
     * @return Shift
     */
    public function setDepartment(\CT\CoreBundle\Entity\Department $department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return \CT\CoreBundle\Entity\Department
     */
    public function getDepartment()
    {
        return $this->department;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->applications = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add application
     *
     * @param \CT\CoreBundle\Entity\Application $application
     *
     * @return Shift
     */
    public function addApplication(\CT\CoreBundle\Entity\Application $application)
    {
        $this->applications[] = $application;

        return $this;
    }

    /**
     * Remove application
     *
     * @param \CT\CoreBundle\Entity\Application $application
     */
    public function removeApplication(\CT\CoreBundle\Entity\Application $application)
    {
        $this->applications->removeElement($application);
    }

    /**
     * Get applications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getApplications()
    {
        return $this->applications;
    }



    public function getBuyedApplicationsCount()
    {
        $validAppCount = 0;

        foreach($this->getApplications() as $app)
        {
            if($app->getState() == "buyed")
                $validAppCount = $validAppCount +1;
        }

        return $validAppCount;
    }
}
