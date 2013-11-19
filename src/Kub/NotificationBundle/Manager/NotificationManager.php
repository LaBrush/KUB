<?php

namespace Kub\NotificationBundle\Manager ;

use Symfony\Component\Security\Core\SecurityContext ;
use Doctrine\ORM\EntityManager ;

class NotificationManager
{
	private $em ;
	private $security ;

	public function __construct( EntityManager $em, SecurityContext $security)
	{
		$this->em = $em ;
		$this->security = $security;
	}

	public function addNotification()
	{

	}
}