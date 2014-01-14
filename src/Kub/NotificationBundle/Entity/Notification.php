<?php

namespace Kub\NotificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Kub\NotificationBundle\Entity\NotificationRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *	"acn" = "ArianeCommentaireNotification", 
 *	"nan" = "NoteAddedNotification", 
 *  "nrn" = "NewRessourceNotification",
 *	"apn" = "ArianePostNotification"
 * })
 *
 * @ORM\HasLifecycleCallbacks()
 * @ORM\MappedSuperclass
 */
abstract class Notification
{
	private $route ;
	private $routeName ;
	private $routeAttr ;
	private $titre ;
	private $type ;
	private $class ;

	abstract public function format($scope);

	/**
	 * @ORM\postLoad()
	 */
	public function init()
	{
		$this->routeAttr = array();
	}

	public function __toString()
    {
        return (string)$this->format();
    }

	public function __construct()
	{
		$this->everyone = false ;

		$this->date = new \DateTime ;
		$this->groupesTarget = new \Doctrine\Common\Collections\ArrayCollection;
		$this->userTarget = new \Doctrine\Common\Collections\ArrayCollection;
	}

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="date", type="datetime")
	 */
	private $date;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="everyone", type="boolean")
	 */
	private $everyone;

	/**
	 * @ORM\ManyToMany(targetEntity="Kub\ClasseBundle\Entity\Groupe")
	 */
	private $groupesTarget;

	/**
	 * @ORM\ManyToMany(targetEntity="Kub\UserBundle\Entity\User")
	 */
	private $userTarget;

	/**
	 * @ORM\ManyToOne(targetEntity="Kub\UserBundle\Entity\User")
	 */
	private $auteur ;

	public function getRoute()
	{
		return $this->route ;
	}

	public function getRouteAttr()
	{
		return $this->routeAttr ;
	}

	public function getTitre()
	{
		return $this->titre ;
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
	 * Set date
	 *
	 * @param \DateTime $date
	 * @return Notification
	 */
	public function setDate($date)
	{
		$this->date = $date;
	
		return $this;
	}

	/**
	 * Get date
	 *
	 * @return \DateTime 
	 */
	public function getDate()
	{
		return $this->date;
	}

	/**
	 * Set everyone
	 *
	 * @param boolean $everyone
	 * @return Notification
	 */
	public function setEveryone($everyone)
	{
		$this->everyone = $everyone;
	
		return $this;
	}

	/**
	 * Get everyone
	 *
	 * @return boolean 
	 */
	public function getEveryone()
	{
		return $this->everyone;
	}

	/**
	 * Get groupesTarget
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getGroupesTarget()
	{
		return $this->groupesTarget;
	}

	/**
	 * Add userTarget
	 *
	 * @param \Kub\UserBundle\Entity\User $userTarget
	 * @return Notification
	 */
	public function addUserTarget(\Kub\UserBundle\Entity\User $userTarget)
	{
		$this->userTarget[] = $userTarget;
	
		return $this;
	}

	/**
	 * Remove userTarget
	 *
	 * @param \Kub\UserBundle\Entity\User $userTarget
	 */
	public function removeUserTarget(\Kub\UserBundle\Entity\User $userTarget)
	{
		if( $this->userTarget->contains($userTarget) )
			$this->userTarget->removeElement($userTarget);
	}

	/**
	 * Get userTarget
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getUserTarget()
	{
		return $this->userTarget;
	}

	/**
	 * Set auteur
	 *
	 * @param \Kub\UserBundle\User $auteur
	 * @return Notification
	 */
	// public function setAuteur(\Kub\UserBundle\User $auteur = null)
	public function setAuteur($auteur = null)
	{
		$this->auteur = $auteur;
	
		return $this;
	}

	/**
	 * Get auteur
	 *
	 * @return \Kub\UserBundle\User 
	 */
	public function getAuteur()
	{
		return $this->auteur;
	}


    /**
     * Add groupesTarget
     *
     * @param \Kub\ClasseBundle\Entity\Groupe $groupesTarget
     * @return Notification
     */
    public function addGroupesTarget(\Kub\ClasseBundle\Entity\Groupe $groupesTarget)
    {
        $this->groupesTarget[] = $groupesTarget;
    
        return $this;
    }

    /**
     * Remove groupesTarget
     *
     * @param \Kub\ClasseBundle\Entity\Groupe $groupesTarget
     */
    public function removeGroupesTarget(\Kub\ClasseBundle\Entity\Groupe $groupesTarget)
    {
        $this->groupesTarget->removeElement($groupesTarget);
    }
}