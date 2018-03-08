<?php

namespace CT\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Department
 *
 * @ORM\Table(name="department")
 * @ORM\Entity(repositoryClass="CT\CoreBundle\Repository\DepartmentRepository")
 */
class Department
{

    /**
     * @ORM\OneToMany(targetEntity="CT\CoreBundle\Entity\Shift", mappedBy="department",cascade={"persist", "remove"})
     */
    private $shifts;


    /**
     * @ORM\ManyToOne(targetEntity="CT\CoreBundle\Entity\Location",inversedBy="departments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;


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
     * @ORM\Column(name="StaffomaticId", type="integer")
     */
    private $staffomaticId;

    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=255)
     */
    private $name;


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
     * Set staffomaticId
     *
     * @param integer $staffomaticId
     *
     * @return Department
     */
    public function setStaffomaticId($staffomaticId)
    {
        $this->staffomaticId = $staffomaticId;

        return $this;
    }

    /**
     * Get staffomaticId
     *
     * @return int
     */
    public function getStaffomaticId()
    {
        return $this->staffomaticId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Department
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set location
     *
     * @param \CT\CoreBundle\Entity\Location $location
     *
     * @return Department
     */
    public function setLocation(\CT\CoreBundle\Entity\Location $location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return \CT\CoreBundle\Entity\Location
     */
    public function getLocation()
    {
        return $this->location;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->shifts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add shift
     *
     * @param \CT\CoreBundle\Entity\Shift $shift
     *
     * @return Department
     */
    public function addShift(\CT\CoreBundle\Entity\Shift $shift)
    {
        $this->shifts[] = $shift;

        return $this;
    }

    /**
     * Remove shift
     *
     * @param \CT\CoreBundle\Entity\Shift $shift
     */
    public function removeShift(\CT\CoreBundle\Entity\Shift $shift)
    {
        $this->shifts->removeElement($shift);
    }

    /**
     * Get shifts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getShifts()
    {
        return $this->shifts;
    }
}
