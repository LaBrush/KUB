<?php

namespace Kub\NoteBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Kub\UserBundle\Entity\Eleve ;

/**
 * NoteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NoteRepository extends EntityRepository
{

	public function findByEleve(Eleve $eleve)
	{
		$qb = $this->createQueryBuilder('n')
			->join('n.controle', 'c')
			->addSelect('c')
			->join('c.matiere', 'm')
			->addSelect('m')
			->join('c.professeur', 'p')
			->addSelect('p')
		;

		return $qb->getQuery()->getArrayResult();
	}

}
