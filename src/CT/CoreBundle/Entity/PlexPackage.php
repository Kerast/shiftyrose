<?php

namespace CT\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlexPackage
 *
 * @ORM\Table(name="plex_package")
 * @ORM\Entity(repositoryClass="CT\CoreBundle\Repository\PlexPackageRepository")
 */
class PlexPackage
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="plex", type="integer")
     */
    private $plex;

    /**
     * @var string
     *
     * @ORM\Column(name="paypalButtonId", type="string", length=255)
     */
    private $paypalButtonId;

    /**
     * @var int
     *
     * @ORM\Column(name="promotion", type="integer")
     */
    private $promotion;


    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string")
     */
    private $image;


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
     * Set price
     *
     * @param float $price
     *
     * @return PlexPackage
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set plex
     *
     * @param integer $plex
     *
     * @return PlexPackage
     */
    public function setPlex($plex)
    {
        $this->plex = $plex;

        return $this;
    }

    /**
     * Get plex
     *
     * @return int
     */
    public function getPlex()
    {
        return $this->plex;
    }

    /**
     * Set paypalButtonId
     *
     * @param string $paypalButtonId
     *
     * @return PlexPackage
     */
    public function setPaypalButtonId($paypalButtonId)
    {
        $this->paypalButtonId = $paypalButtonId;

        return $this;
    }

    /**
     * Get paypalButtonId
     *
     * @return string
     */
    public function getPaypalButtonId()
    {
        return $this->paypalButtonId;
    }

    /**
     * Set promotion
     *
     * @param integer $promotion
     *
     * @return PlexPackage
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
     * Set image
     *
     * @param string $image
     *
     * @return string
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
}

