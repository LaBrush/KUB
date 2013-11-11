<?php

namespace Kub\EDTBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NoHoraireConflict extends Constraint
{
    public $message = "Un horaire défini pour ce cours entre en conflit avec un autre déjà défini.";

    public function validatedBy()
	{
		return "time_edt_no_conflict" ;
	}
}