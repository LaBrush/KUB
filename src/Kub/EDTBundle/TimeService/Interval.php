<?php

namespace Kub\EDTBundle\TimeService ;

use Kub\EDTBundle\Entity\Horaire ;

class Interval
{
	private $horaire ;
	private $debut ;
	private $fin ;
	private $liste_horaires ;

	public function __construct(array $liste_horaires, $horaire = null)
	{
		$this->liste_horaires = $liste_horaires ;

		if($horaire)
		{
			$this->setHoraire( $horaire );
		}
	}

	public function setHoraire(Horaire $horaire)
	{
		$this->horaire = $horaire ;

		$this->debut = $this->roundTo( clone $this->horaire->getDebut() );
		$this->fin   = $this->roundTo( clone $this->horaire->getFin() );
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

		switch (get_class($previous)){
			case 'Kub\EDTBundle\TimeService\Interval':
				$this->horaire->setDebut( $previous->getHoraire()->getFin() );
				break;
			case 'DateTime':
				$this->horaire->setDebut( $previous );
				break;
			default:
				throw new \InvalidArgumentException("DateTime or Kub\EDTBundle\TimeService\Interval expected, " . get_class($previous) . ' given');
				break;
		}
		
		switch (get_class($next)){
			case 'Kub\EDTBundle\TimeService\Interval':
				$this->horaire->setFin( $next->getHoraire()->getDebut() );
				break;
			case 'DateTime':
				$this->horaire->setFin( $next );
				break;
			default:
				throw new \InvalidArgumentException("DateTime or Kub\EDTBundle\TimeService\Interval expected, " . get_class($next) . ' given');
				break;
		}

		return $this ; //Pour le chainage de fonctions
	}

	public function getRowSpan()
	{
		$span = array_search($this->fin, $this->liste_horaires) - array_search($this->debut, $this->liste_horaires);

		return $span ;
	}

	public function roundTo(\Datetime $datetime)
	{
		$time = $datetime->format('i');
		$time = $time - ( $time % 5 ) + ( $time % 5 > 2.5 ? 5 : 0 );

		$datetime->setTime( $datetime->format('H'), $time );

		return  $datetime ;
	}
}