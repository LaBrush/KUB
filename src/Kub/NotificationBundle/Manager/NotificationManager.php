<?php

namespace Kub\NotificationBundle\Manager ;

use Symfony\Component\Security\Core\SecurityContext ;
use Doctrine\ORM\EntityManager ;

use Kub\UserBundle\Entity\User ;

class NotificationManager
{
	private $em ;
	private $security ;

	public function __construct( EntityManager $em, SecurityContext $security)
	{
		$this->em = $em ;
		$this->security = $security;
	}

	public function addNotification($type)
	{
		$type = 'Kub\NotificationBundle\Entity\\' . $type ;		

		$notification = new $type ;
		$notification->setAuthor( $this->security->getToken()->getUser() );
		$notification->addUserTarget( $this->security->getToken()->getUser() );

		$this->em->persist($notification);
		$this->em->flush();
	}

	public function getNotifications()
	{
		$user =  $this->security->getToken()->getUser();

		$notifications = $this->em->getRepository('KubNotificationBundle:Notification')->findByUser($user);

		return $notifications ;
	}
}