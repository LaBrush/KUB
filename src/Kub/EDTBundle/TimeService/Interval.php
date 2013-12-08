<?php

namespace Kub\EDTBundle\TimeService\Interval ;

use Kub\EDTBundle\Entity\Horaire ;

class Interval
{
	private $horaire ;

	public function setHoraire(Horaire $horaire)
	{
		$this->horaire = $horaire ;
	}

	public function getHoraire()
	{
		return $this->horaire ;
	}

	public function getColSpans()
	{
		$debut = clone $this->horaire->getDebut();
		$fin = clone $this->fin->getFin();

		throw new \Exception($debut->format('m'));
		
	}
}