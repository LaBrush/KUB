<?php

namespace Kub\MessagerieBundle\Services ;

class MessageManager
{
	private $em ;
	private $security ;

	public function __construct($em, $security)
	{
		$this->em = $em ;
		$this->security = $security ;
	}

	public function getNbUnreadMessages()
	{
		return $this->em->createQuery('
			SELECT COUNT(mu) FROM KubMessagerieBundle:MessageUser mu
			JOIN mu.user u
			WHERE mu.readed = false
			AND u.id = :u_id
		')
		->setParameter('u_id', $this->security->getToken()->getUser())
		->getSingleScalarResult()
		;
	}
}