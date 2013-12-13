<?php

namespace Kub\EDTBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManager ;


class NoHoraireConflictValidator extends ConstraintValidator
{

	private $em ;

	public function __construct(EntityManager $em)
	{
		$this->em = $em ;
	}

	public function validate($cours, Constraint $constraint)
	{
		$conflits = array();

		foreach ($cours->getHoraires() as $horaire) {
			$conflits = array_merge($conflits, $this->em->getRepository("KubEDTBundle:Horaire")->findConflictualCours($horaire));
		}

		$conflits = array_merge($conflits, $this->getNonPersistedConlficts($horaire));

		if(count($conflits) > 0)
		{	
			$this->context->addViolation($constraint->getMessage($conflits));
		}
	}

	public function getNonPersistedConlficts($horaire_ref)
	{
		$horaires = $horaire_ref->getCours()->getHoraires();
		$conflits = array();

		$horaire_ref_debut = $horaire_ref->getDebut()->getTimestamp();
		$horaire_ref_fin = $horaire_ref->getFin()->getTimestamp();
		$horaire_ref_jour = $horaire_ref->getJour()->getId();

		foreach ($horaires as $key => $horaire) {
			
			$horaire_debut = $horaire->getDebut()->getTimestamp() ;
			$horaire_fin = $horaire->getFin()->getTimestamp() ;

			if($horaire != $horaire_ref)
			{
				if(
					(
						$horaire_debut > $horaire_ref_debut &&
						$horaire_debut < $horaire_ref_fin
					) ||
					(
						$horaire_fin > $horaire_ref_debut &&
						$horaire_fin < $horaire_ref_fin
					) ||
					(
						(
							$horaire_ref_debut > $horaire_debut &&
							$horaire_ref_debut < $horaire_fin
						) &&
						(
							$horaire_ref_fin > $horaire_debut &&
							$horaire_ref_fin < $horaire_fin
						)
					)
					&&
					$horaire->getJour()->getId() != $horaire_ref_jour
				)
				{
					$conflits[] = $horaire ;	
				}
			}
		}

		return $conflits ;
	}
}