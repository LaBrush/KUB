<?php

namespace Kub\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * EleveRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EleveRepository extends UserRepository
{
	// fonction utilisee pour charger l'ensemble des données de l'utilisateur
	public function findOneByUsername($username)
	{
		$qb = $this->createQueryBuilder("e")
			->leftJoin('e.groupes', 'g')
			->addSelect('g')
			
			->leftJoin('e.niveau', 'ni')
			->addSelect('ni')
			
			->leftJoin('e.tuteurs', 't')
			->addSelect('t')

			->leftJoin('e.notes', 'n')
			->addSelect('n')

			->leftJoin('n.controle', 'c')
			->addSelect('c')

			->where("e.username = :username")
			->setParameter("username", $username)
		;

		return $qb->getQuery()->getSingleResult();
	}

	public function findByNiveauName($niveau)
	{
		$qb = $this->createQueryBuilder("e")
			->join('e.niveau', 'n')
			->where("n.name = :niveau")
			->setParameter("niveau", $niveau)
		;

		return $qb->getQuery()->getResult();
	}
}
