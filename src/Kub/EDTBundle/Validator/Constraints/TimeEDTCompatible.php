<?php

namespace Kub\EDTBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class TimeEDTCompatible extends Constraint
{
    public $message = "L'horaire ne correspond pas aux paramètres définis.";

    public function validatedBy()
	{
		return "time_edt_compatible" ;
	}
}