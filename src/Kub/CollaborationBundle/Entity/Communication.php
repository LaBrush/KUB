<?php

namespace Kub\CollaborationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Communication
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Communication
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
     * @ORM\OneToOne(targetEntity="Kub\CollaborationBundle\Entity\Projet", mappedBy="communication")
     */
    private $projet ;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Kub\CollaborationBundle\Entity\Sujet", mappedBy="communication", cascade={"all"})
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private $sujets;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sujets = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set projet
     *
     * @param \Kub\CollaborationBundle\Entity\Projet $projet
     * @return Communication
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

    /**
     * Add sujets
     *
     * @param \Kub\CollaborationBundle\Entity\Sujet $sujets
     * @return Communication
     */
    public function addSujet(\Kub\CollaborationBundle\Entity\Sujet $sujets)
    {
        $this->sujets[] = $sujets;
    
        return $this;
    }

    /**
     * Remove sujets
     *
     * @param \Kub\CollaborationBundle\Entity\Sujet $sujets
     */
    public function removeSujet(\Kub\CollaborationBundle\Entity\Sujet $sujets)
    {
        $this->sujets->removeElement($sujets);
    }

    /**
     * Get sujets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSujets()
    {
        return $this->sujets;
    }
}