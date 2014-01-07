<?php

namespace Kub\CollaborationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tache
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Tache
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
     * @var integer
     *
     * @ORM\Column(name="rang", type="integer")
     */
    private $rang;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="echeance", type="date")
	 */
	private $echeance;

	/**
	 * @ORM\ManyToOne(targetEntity="Kub\CollaborationBundle\Entity\Organisateur", cascade={"persist"}, inversedBy="taches")
	 */
	private $organisateur ;

	/**
	 * @ORM\ManyToMany(targetEntity="Kub\UserBundle\Entity\User", cascade={"persist"})
	 */
	private $participants ;

	/**
     * @ORM\ManyToOne(targetEntity="Kub\CollaborationBundle\Entity\ListeTaches", inversedBy="taches", cascade={"persist", "merge"})
     */
    private $listeTaches ;

	public function __toString()
	{
		return $this->getName();
	}

	public function __construct()
	{
		$this->rang = 1 ;
		$this->participants = new \Doctrine\Common\Collections\ArrayCollection();
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
	 * Set echeance
	 *
	 * @param \DateTime $echeance
	 * @return Tache
	 */
	public function setEcheance($echeance)
	{
		$this->echeance = $echeance;
	
		return $this;
	}

	/**
	 * Get echeance
	 *
	 * @return \DateTime 
	 */
	public function getEcheance()
	{
		return $this->echeance;
	}

	/**
	 * Set organisateur
	 *
	 * @param \Kub\CollaborationBundle\Entity\Organisateur $organisateur
	 * @return Tache
	 */
	public function setOrganisateur(\Kub\CollaborationBundle\Entity\Organisateur $organisateur = null)
	{
		$this->organisateur = $organisateur;
	
		return $this;
	}

	/**
	 * Get organisateur
	 *
	 * @return \Kub\CollaborationBundle\Entity\Organisateur 
	 */
	public function getOrganisateur()
	{
		return $this->organisateur;
	}
	
	/**
	 * Add participants
	 *
	 * @param \Kub\UserBundle\Entity\User $participants
	 * @return Tache
	 */
	public function addParticipant(\Kub\UserBundle\Entity\User $participants)
	{
		$this->participants[] = $participants;
	
		return $this;
	}

	/**
	 * Remove participants
	 *
	 * @param \Kub\UserBundle\Entity\User $participants
	 */
	public function removeParticipant(\Kub\UserBundle\Entity\User $participants)
	{
		$this->participants->removeElement($participants);
	}

	/**
	 * Get participants
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getParticipants()
	{
		return $this->participants;
	}

	/**
	 * Set name
	 *
	 * @param string $name
	 * @return Tache
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
     * Set rang
     *
     * @param integer $rang
     * @return Tache
     */
    public function setRang($rang)
    {
        $this->rang = $rang;
    
        return $this;
    }

    /**
     * Get rang
     *
     * @return integer 
     */
    public function getRang()
    {
        return $this->rang;
    }

    /**
     * Set listeTaches
     *
     * @param \Kub\CollaborationBundle\Entity\ListeTaches $listeTaches
     * @return Tache
     */
    public function setListeTaches(\Kub\CollaborationBundle\Entity\ListeTaches $listeTaches = null)
    {
        $this->listeTaches = $listeTaches;
    
        return $this;
    }

    /**
     * Get listeTaches
     *
     * @return \Kub\CollaborationBundle\Entity\ListeTaches 
     */
    public function getListeTaches()
    {
        return $this->listeTaches;
    }
}