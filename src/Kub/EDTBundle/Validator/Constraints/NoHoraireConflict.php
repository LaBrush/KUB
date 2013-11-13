<?php

namespace Kub\EDTBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NoHoraireConflict extends Constraint
{
    public $message = "Un horaire défini pour ce cours entre en conflit avec un autre déjà défini.";

    public function getMessage($horaires = null)
    {
    	$message = "";

    	if($horaires !== null)
    	{
    		$message = $this->showConflicts($horaires);
    	}

    	return $this->message . " " . $message ;
    }

    public function showConflicts($horaires)
    {
    	$message = "";

    	foreach ($horaires as $key => $horaire) {
    		$message = $horaire . " " ;
    	}

    	return $message ;
    }

    public function validatedBy()
	{
		return "time_edt_no_conflict" ;
	}

	public function getTargets()
	{
	    return self::CLASS_CONSTRAINT;
	}
}