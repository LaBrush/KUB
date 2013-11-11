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
    	if($this->em->getRepository("KubEDTBundle:Horaire")->countConflictualCours($horaire) > 0)
    	{	
    		$this->context->addViolation($constraint->message);
    	}
    }

    public function getTargets()
	{
	    return self::CLASS_CONSTRAINT;
	}
}