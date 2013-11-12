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

    public function validate($horaire, Constraint $constraint)
    {
    	$conflits = $this->em->getRepository("KubEDTBundle:Horaire")->findConflictualCours($horaire);

    	if(count($conflits) > 0)
    	{	
    		$this->context->addViolation($constraint->getMessage($conflits));
    	}
    }
}