<?php

namespace Kub\NotificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NoteAddedNotification
 * @ORM\Entity
 */
class WelcomeNotification extends Notification
{
	
	public function init()
	{
		parent::init();

		$this->route = "fos_user_profile_edit" ;
		$this->routeTitle = "Voir votre compte" ;
		$this->titre = "Bienvenue !";
		$this->type = "welcome" ;
		$this->class = 'WelcomeNotification';
	}


	/**
	 * @ORM\OneToOne(targetEntity="Kub\UserBundle\Entity\User", mappedBy="notification")
	 */
	private $user ;

	public function format($scope = null)
	{
		return "Bienvenue sur le Kub " . $user->getPrenom() . " il faut trouver la suite ! " ;
	}


    /**
     * Set user
     *
     * @param \Kub\UserBundle\Entity\User $user
     * @return WelcomeNotification
     */
    public function setUser(\Kub\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Kub\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}