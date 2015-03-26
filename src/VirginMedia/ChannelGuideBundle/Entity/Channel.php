<?php

namespace VirginMedia\ChannelGuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Channel
 *
 * @ORM\Table(name="channel")
 * @ORM\Entity(repositoryClass="VirginMedia\ChannelGuideBundle\Entity\ChannelRepository")
 */
class Channel
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;


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
     * Set title
     *
     * @param string $title
     * @return Channel
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set number
     *
     * @param integer $number
     * @return Channel
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @ORM\ManyToMany(targetEntity="VirginMedia\ChannelGuideBundle\Entity\Package", cascade={"all"})
     * @ORM\JoinTable(name="package_channel_mapping",
     *      joinColumns={@ORM\JoinColumn(name="channel_id", referencedColumnName="id",onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="package_id", referencedColumnName="id",onDelete="CASCADE")}
     *)
     */

    private $packageChannels;

    /**
         * @ORM\ManyToMany(targetEntity="VirginMedia\ChannelGuideBundle\Entity\Region", cascade={"all"})
     * @ORM\JoinTable(name="region_channel_mapping",
     *      joinColumns={@ORM\JoinColumn(name="channel_id", referencedColumnName="id",onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="region_id", referencedColumnName="id",onDelete="CASCADE")}
     *)
     */

    private $regionChannels;

    public function __construct()
    {
        $this->packageChannels = new ArrayCollection();
        $this->regionChannels = new ArrayCollection();
    }
}
