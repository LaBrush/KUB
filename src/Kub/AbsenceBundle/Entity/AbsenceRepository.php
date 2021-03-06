<?php

namespace Kub\AbsenceBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * AppelRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AbsenceRepository extends EntityRepository
{
	public function findByCoursId($id)
	{
			$qb = $this->createQueryBuilder('a')
			->join('a.appel', 'ap')
			->addSelect('ap')

			->leftJoin('ap.horaire', 'h')
			->addSelect('h')

			->leftJoin('h.cours', 'c')

			->join('a.eleve', 'e')
			->orderBy('e.nom, e.prenom', 'ASC')

			// ->where('c.id = :cid')
			// ->setParameter('cid', $id)
		;

		return $qb->getQuery()->getResult();
	}
}
