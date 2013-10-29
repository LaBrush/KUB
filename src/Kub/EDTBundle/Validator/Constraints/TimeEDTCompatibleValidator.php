<?php

namespace Kub\EDTBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Kub\EDTBundle\Services\TimeService ;

class TimeEDTCompatibleValidator extends ConstraintValidator
{

	private $time ;

	public function __construct(TimeService $time)
	{
		$this->time = $time ;
	}

    public function validate($value, Constraint $constraint)
    {

    	if(!in_array($value->format('i'), $this->time->getMinutesForHour($value->format('G'))))
		$this->context->addViolation($constraint->message);
    }
}