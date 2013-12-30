<?php

namespace Kub\AbsenceBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * AppelRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AppelRepository extends EntityRepository
{

	public function findOneOrNullByCoursAndSemaine(\Kub\EDTBundle\Entity\Cours $cours, \Kub\EDTBundle\Entity\Semaine $semaine)
	{
		$qb = $this->createQueryBuilder('a')
			->join('a.cours', 'c')
			->addSelect('c')

			->join('c.groupes', 'g')
			->addSelect('g')
			->join('g.eleves', 'e')
			->addSelect('e')
			->leftJoin('e.photo', 'p')
			->addSelect('p')

			->join('a.semaine', 's')
			->addSelect('s')

			->where('s.annee = :s_annee')
			->setParameter('s_annee', $semaine->getAnnee())

			->andWhere('s.numero = :s_numero')
			->setParameter('s_numero', $semaine->getNumero())

			->andWhere('c.id = :cid')
			->setParameter('cid', $cours->getId())
		;

		// throw new \Exception($qb->getQuery()->getDql());
		

		return $qb->getQuery()->getOneOrNullResult();
	}

}
