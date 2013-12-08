<?php

namespace Kub\EDTBundle\TimeService ;

use Kub\EDTBundle\Entity\Horaire ;

class Interval
{
	private $horaire ;
	private $debut ;
	private $fin ;

	public function __construct($horaire = null)
	{
		if($horaire)
		{
			$this->setHoraire( $horaire );
		}
	}

	public function setHoraire(Horaire $horaire)
	{
		$this->horaire = $horaire ;

		$this->debut = $this->roundToHalf( $this->horaire->getDebut() );
		$this->fin   = $this->roundToHalf( $this->horaire->getFin() );
	}

	public function getHoraire()
	{
		return $this->horaire ;
	}

	public function getDebut(){ return $this->debut; }
	public function getFin(){ return $this->fin; }

	//Calcul le temps nécessaire pour prendre le rowspan afin de combler le trou entre deux cours - avous que t'as rien pigé !
	public function link($previous, $next){
		$this->horaire = new Horaire ;

		switch (get_class($previous)) {
			case '\Kub\EDTBundle\TimeService\Interval':
				$this->horaire->setDebut( $previous->getHoraire()->getFin() );
				break;
			case '\Datetime':
				$this->horaire->setDebut( $previous );
			default:
				throw new \InvalidArgumentException("\Datetime or \Kub\EDTBundle\TimeService\Interval expected");
				break;
		}

		switch (get_class($next)) {
			case '\Kub\EDTBundle\TimeService\Interval':
				$this->horaire->setFin( $previous->getHoraire()->getDebut() );
				break;
			case '\Datetime':
				$this->horaire->setFin( $previous );
			default:
				throw new \InvalidArgumentException("\Datetime or \Kub\EDTBundle\TimeService\Interval expected");
				break;
		}
	}

	public function getRowSpan()
	{
		$debut = clone $this->horaire->getDebut();
		$fin = clone $this->horaire->getFin();

		$debut = $this->roundToHalf( $debut );
		$fin   = $this->roundToHalf( $fin );

		$diff = $debut->diff($fin, true);
		$span = ($diff->h * 60 + $diff->i) / 30 ;
	
		return $span ;
	}

	public function roundToHalf(\Datetime $datetime)
	{
		$time = $datetime->format('i');
		$time = $time - ( $time % 30 ) + ( $time % 30 > 15 ? 30 : 0 );

		$datetime->setTime( $datetime->format('H'), $time );

		return  $datetime ;
	}
}