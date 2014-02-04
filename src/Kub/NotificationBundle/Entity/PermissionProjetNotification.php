<?php

namespace Kub\NotificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class PermissionProjetNotification extends Notification
{
	
	public function init()
	{
		parent::init();

		$this->route = "kub_collaboration_projet_show" ;
		$this->routeAttr['slug'] = $this->getPermission()->getProjet()->getSlug();
		$this->routeTitle = "Aller au projet" ;

		$this->titre = "Vous avez été ajouté à un projet";
		$this->type = "projet" ;
		$this->class = 'PermissionProjetNotification';
	}


	/**
	 * @ORM\OneToOne(targetEntity="Kub\CollaborationBundle\Entity\Permission", mappedBy="notification")
	 */
	private $permission ;

	public function format($scope = null)
	{
		return "Vous avez été ajouté au projet " . $this->getPermission()->getProjet() ;
	}

	/**
	 * Set permission
	 *
	 * @param \Kub\CollaborationBundle\Entity\Permission $permission
	 * @return PermissionProjetNotification
	 */
	public function setPermission(\Kub\CollaborationBundle\Entity\Permission $permission = null)
	{
		$this->permission = $permission;
	
		return $this;
	}

	/**
	 * Get permission
	 *
	 * @return \Kub\CollaborationBundle\Entity\Permission 
	 */
	public function getPermission()
	{
		return $this->permission;
	}
}