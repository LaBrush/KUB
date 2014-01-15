<?php

namespace Kub\EDTBundle\Entity;

use Doctrine\ORM\EntityRepository;

use Kub\UserBundle\Entity\Eleve ;
use Kub\UserBundle\Entity\Professeur ;

/**
 * CoursRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CoursRepository extends EntityRepository
{

	public function findOneById($id)
	{
		$qb = $this->createQueryBuilder('c')
			->join('c.professeur', 'p')
			->addSelect('p')
			
			->join('c.groupes', 'g')
			->addSelect('g')
			
			->join('g.eleves', 'e')
			->addSelect('e')

			->join('c.matiere', 'm')
			->addSelect('m')

			->where('c.id = :id')
			->setParameter('id', $id)
		;

		return $qb->getQuery()->getSingleResult();		
	}

	public function getCurrentCoursOf(\Kub\UserBundle\Entity\Professeur $professeur)
	{
		$qb = $this->createQueryBuilder('c')
			->join('c.professeur', 'p')
			->addSelect('p')
			->join('c.groupes', 'g')
			->addSelect('g')
			->join('c.horaires', 'h')
			->addSelect('h')
			->join('h.jour', 'j')
			->addSelect('j')
			->join('h.semaines', 's')
			->addSelect('s')
			
			->where('p.id = :id')
			->setParameter('id', $professeur->getId())
			->andWhere('j.id = :day_id')
			->setParameter('day_id', date('N'))
			->andWhere('CURRENT_TIME() BETWEEN h.debut AND h.fin')
			->andWhere('s.numero = :w')
			->setParameter('w', date('W'))
			->andWhere('s.annee = :y')
			->setParameter('y', date('y'))
		;

		return $qb->getQuery()->getOneOrNullResult();
	}

	public function findByGroupeIdAndProfesseurId($groupe_id, $professeur_id)
	{
		$qb = $this->createQueryBuilder('c')
			->join('c.professeur', 'p')
			->addSelect('p')
			->join('c.groupes', 'g')
			->addSelect('g')
			
			->where('p.id = :pid')
			->setParameter('pid', $professeur_id)
		
			->andWhere('g.id = :gid')
			->setParameter('gid', $groupe_id)
		;

		return $qb->getQuery()->getResult();
	}

	public function getByIdWithAll($id)
	{
		$qb = $this->createQueryBuilder('c')
			->join('c.professeur', 'p')
			->addSelect('p')
			->join('c.groupes', 'g')
			->addSelect('g')
			->join('c.horaires', 'h')
			->addSelect('h')
			->join('h.jour', 'j')
			->addSelect('j')
			->join('h.semaines', 's')
			->addSelect('s')
			
			->where('c.id = :id')
			->setParameter('id', $id)
		;

		return $qb->getQuery()->getResult();
	}

}
