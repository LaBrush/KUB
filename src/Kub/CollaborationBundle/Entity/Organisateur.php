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
     * @ORM\OneToOne(targetEntity="Kub\CollaborationBundle\Entity\Projet", mappedBy="organisateur")
     */
    private $projet ;

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

    /**
     * Set projet
     *
     * @param \Kub\CollaborationBundle\Entity\Projet $projet
     * @return Organisateur
     */
    public function setProjet(\Kub\CollaborationBundle\Entity\Projet $projet = null)
    {
        $this->projet = $projet;
    
        return $this;
    }

    /**
     * Get projet
     *
     * @return \Kub\CollaborationBundle\Entity\Projet 
     */
    public function getProjet()
    {
        return $this->projet;
    }
}