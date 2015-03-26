<?php

namespace VirginMedia\ChannelGuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Package
 *
 * @ORM\Table(name="package")
 * @ORM\Entity(repositoryClass="VirginMedia\ChannelGuideBundle\Entity\PackageRepository")
 */
class Package
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=2)
     */
    private $code;


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
     * Set name
     *
     * @param string $name
     * @return Package
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
     * Set code
     *
     * @param string $code
     * @return Package
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @ORM\ManyToMany(targetEntity="VirginMedia\ChannelGuideBundle\Entity\Package", cascade={"all"})
     * @ORM\JoinTable(name="closure_table",
     *      joinColumns={@ORM\JoinColumn(name="ancestor_id", referencedColumnName="id",onDelete="CASCADE", nullable=true)},
     *      inverseJoinColumns={@ORM\JoinColumn(name="descendant_id", referencedColumnName="id",onDelete="CASCADE",nullable=true)}
     *)
     */

    private $packageRelations;

    public function __toString()
    {
        return $this->getName();
    }


    public function __construct()
    {
        $this->packageRelations = new ArrayCollection();
    }
}
