<?php

namespace Kub\ClasseBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Kub\UserBundle\Entity\Professeur ;

/**
 * GroupeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GroupeRepository extends EntityRepository
{
	public function getGroupesOfProfesseur(Professeur $professeur)
	{
		$qb = $this->createQueryBuilder("g")
			->join('g.cours', 'c')
			->join('c.professeur', 'p')
			->join('g.eleves', 'e')
			->addSelect('e')
			->where('p.id = :id')
			->setParameter('id', $professeur->getId())
			;

		return $qb->getQuery()->getResult();
	}

	public function findOneByName($name)
	{
		$qb = $this->createQueryBuilder("g")
			->join('g.eleves', 'e')
			->addSelect('e')
			->join('g.niveau', 'n')
			->addSelect('n')
			->where('g.name = :name')
			->setParameter('name', $name)
		;

		return $qb->getQuery()->getSingleResult();		
	}
}
