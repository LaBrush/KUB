<?php

namespace Kub\ClasseBundle\Entity;

use Doctrine\ORM\EntityRepository;

use Kub\UserBundle\Entity\Professeur ;
use Kub\UserBundle\Entity\User ;

/**
 * GroupeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GroupeRepository extends EntityRepository
{
	public function findByUser(User $user)
	{
		$qb = $this->createQueryBuilder("g");

		switch ($user->getClass()) {
			case 'professeur':
				$qb
					->join('g.cours', 'c')
					->join('c.professeur', 'p')
					
					->join('g.niveau', 'n')
					->addSelect('n')

					->where('p.id = :id')
					->setParameter('id', $user->getId())
				;
				break;
			case 'eleve':
				$qb
					->join('g.eleves', 'e')
					
					->join('g.niveau', 'n')
					->addSelect('n')

					->where('e.id = :id')
					->setParameter('id', $user->getId())
				;
				break;
			default:
				throw new \Exception("Professeur or Eleve expected, " . get_class($user) . " given");
				break;
		}

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

	public function findOneByNameWithAll($name)
	{
		$qb = $this->createQueryBuilder("g")
			->join('g.eleves', 'e')
			->addSelect('e')
			->join('g.niveau', 'n')
			->addSelect('n')
			->addSelect('g.controles', 'c')
			->where('g.name = :name')
			->setParameter('name', $name)
		;

		return $qb->getQuery()->getSingleResult();	
	}
}
