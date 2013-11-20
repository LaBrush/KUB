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
 * @ORM\DiscriminatorMap({"acn" = "ArianeCommentaireNotification"})
 *
 * @ORM\HasLifecycleCallbacks()
 */
abstract class Notification
{
    /**
     * @ORM\postLoad()
     */
    public function init()
    {
        $this->everyone = false ;
        $this->date = new \DateTime ;
    }

    public function __construct()
    {
        $this->init();
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
    private $author ;

    private $route ;

    private $titre ;

    abstract function getContenu();

    public function getTitre()
    {
        return $this->titre ;
    }

    public function getRoute()
    {
        return $this->route ;
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
     * Add groupesTarget
     *
     * @param \Kub\UserBundle\Entity\Groupe $groupesTarget
     * @return Notification
     */
    public function addGroupesTarget(\Kub\UserBundle\Entity\Groupe $groupesTarget)
    {
        $this->groupesTarget[] = $groupesTarget;
    
        return $this;
    }

    /**
     * Remove groupesTarget
     *
     * @param \Kub\UserBundle\Entity\Groupe $groupesTarget
     */
    public function removeGroupesTarget(\Kub\UserBundle\Entity\Groupe $groupesTarget)
    {
        $this->groupesTarget->removeElement($groupesTarget);
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
     * Set author
     *
     * @param \Kub\UserBundle\User $author
     * @return Notification
     */
    // public function setAuthor(\Kub\UserBundle\User $author = null)
    public function setAuthor($author = null)
    {
        $this->author = $author;
    
        return $this;
    }

    /**
     * Get author
     *
     * @return \Kub\UserBundle\User 
     */
    public function getAuthor()
    {
        return $this->author;
    }
}