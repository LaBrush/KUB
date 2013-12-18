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

	public function addNotification($type, array $config)
	{
		$type = 'Kub\NotificationBundle\Entity\\' . $type ;		
		$user = $this->security->getToken()->getUser();		

		$notification = new $type ;
		$notification->setAuteur( $user );
		$notification->setEveryone(false);

		if(array_key_exists("userTarget", $config)){
			if(is_array($config["userTarget"]))
			{
				for ($i = 0; $i < count($config["userTarget"]) ; $i++) { 
					$notification->addUserTarget( $config["userTarget"][$i] );		
				}
			}
			else
			{
				$notification->addUserTarget( $config["userTarget"] );
			}

			$notification->removeUserTarget($user);
			unset($config["userTarget"]);
		}

		if(array_key_exists("groupeTarget", $config)){
			if(is_array($config["groupeTarget"]))
			{
				for ($i = 0; $i < count($config["groupeTarget"]) ; $i++) { 
					$notification->addGroupeTarget( $config["groupeTarget"][$i] );		
				}
			}
			else
			{
				$notification->addGroupeTarget( $config["groupeTarget"] );
			}

			unset($config["groupeTarget"]);
		}

		foreach ($config as $key => $value) {
			$function = 'set' . $key ;
			$notification->$function($value);
		}
		
		$this->em->persist($notification);
		$this->em->flush();
	}

	public function getNotifications($offset)
	{
		$user =  $this->security->getToken()->getUser();

		$notifications = $this->em->getRepository('KubNotificationBundle:Notification')->findByUser($user, $offset);

		return $notifications ;
	}
}