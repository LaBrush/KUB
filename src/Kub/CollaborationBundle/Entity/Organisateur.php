<?php

namespace Kub\CollaborationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Organisateur
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Organisateur
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Kub\CollaborationBundle\Entity\ListeTaches", mappedBy="organisateur", cascade={"all"})
     */
    private $listeTaches;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->listeTaches = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add listeTaches
     *
     * @param \Kub\CollaborationBundle\Entity\ListeTaches $listeTaches
     * @return Organisateur
     */
    public function addListeTache(\Kub\CollaborationBundle\Entity\ListeTaches $listeTaches)
    {
        $this->listeTaches[] = $listeTaches;
    
        return $this;
    }

    /**
     * Remove listeTaches
     *
     * @param \Kub\CollaborationBundle\Entity\ListeTaches $listeTaches
     */
    public function removeListeTache(\Kub\CollaborationBundle\Entity\ListeTaches $listeTaches)
    {
        $this->listeTaches->removeElement($listeTaches);
    }

    /**
     * Get listeTaches
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getListeTaches()
    {
        return $this->listeTaches;
    }
}