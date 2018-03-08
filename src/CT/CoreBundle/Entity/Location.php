<?php

namespace CT\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Location
 *
 * @ORM\Table(name="location")
 * @ORM\Entity(repositoryClass="CT\CoreBundle\Repository\LocationRepository")
 */
class Location
{

    /**
     * @ORM\OneToMany(targetEntity="CT\CoreBundle\Entity\Department", mappedBy="location",cascade={"persist", "remove"})
     */
    private $departments;


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
     * @ORM\Column(name="StaffomaticId", type="integer", unique=true)
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
     * @return Location
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
     * @return Location
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
     * Constructor
     */
    public function __construct()
    {
        $this->departments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add department
     *
     * @param \CT\CoreBundle\Entity\Department $department
     *
     * @return Location
     */
    public function addDepartment(\CT\CoreBundle\Entity\Department $department)
    {
        $this->departments[] = $department;

        return $this;
    }

    /**
     * Remove department
     *
     * @param \CT\CoreBundle\Entity\Department $department
     */
    public function removeDepartment(\CT\CoreBundle\Entity\Department $department)
    {
        $this->departments->removeElement($department);
    }

    /**
     * Get departments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDepartments()
    {
        return $this->departments;
    }
}
