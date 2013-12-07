<?php

namespace Kub\MessageBundle\EntityManager;

use FOS\MessageBundle\EntityManager\ThreadManager as BaseThreadManager;
use Doctrine\ORM\EntityManager;
use FOS\MessageBundle\Model\ThreadInterface;
use FOS\MessageBundle\Model\ReadableInterface;
use FOS\MessageBundle\Model\ParticipantInterface;
use Doctrine\ORM\Query\Builder;

class ThreadManager extends BaseThreadManager
{
	public function findParticipantInboxThreads(ParticipantInterface $participant)
	{	
		return $this->getParticipantInboxThreadsQueryBuilder($participant)
			->getQuery()
			->execute();
	}
}