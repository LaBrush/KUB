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
		$default = array(
		
			"everyOne" => false,
			"specific" => array()			

		);
		$user = $this->security->getToken()->getUser();		

		$config = array_merge($config, $default);

		$notification = new $type ;
		$notification->setAuteur( $user );

		if(array_key_exists("userTarget", $config))
		{
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
		}

		if(array_key_exists("groupeTarget", $config))
		{
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
		}

		if(array_key_exists("contenu", $config))
		{
			$notification->setContenu( $config["contenu"] );
		}

		$notification->setEveryone( $config["everyOne"] );

		// throw new \Exception($notification->getNote());
		
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