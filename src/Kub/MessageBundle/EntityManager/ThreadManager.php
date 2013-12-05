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
	public function getParticipantInboxThreadsQueryBuilder(ParticipantInterface $participant)
	{	
		return $this->repository->createQueryBuilder('t')
			->innerJoin('t.metadata', 'tm')
			->addSelect('tm')
			->innerJoin('tm.participant', 'p')
			->addSelect('p')
			->innerJoin('t.createdBy', 'c')
			->addSelect('c')
			->innerJoin('t.messages', 'm')
			->addSelect('m')
			->innerJoin('m.metadata', 'mm')
			->addSelect('mm')

			// the participant is in the thread participants or the thread creator
			->andWhere('(p.id = :user_id) OR (c.id = :user_id)')
			->setParameter('user_id', $participant->getId())

			// the thread does not contain spam or flood
			->andWhere('t.isSpam = :isSpam')
			->setParameter('isSpam', false, \PDO::PARAM_BOOL)

			// the thread is not deleted by this participant
			->andWhere('tm.isDeleted = :isDeleted')
			->setParameter('isDeleted', false, \PDO::PARAM_BOOL)

			// there is at least one message written by an other participant
			->andWhere('tm.lastMessageDate IS NOT NULL')

			// sort by date of last message written by an other participant
			->orderBy('tm.lastMessageDate', 'DESC')
		;
	}
}