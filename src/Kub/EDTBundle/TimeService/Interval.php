<?php

namespace Kub\EDTBundle\TimeService ;

use Kub\EDTBundle\Entity\Horaire ;

class Interval
{
	private $horaire ;

	public function __construct(Horaire $horaire = null)
	{
		$this->horaire = $horaire ;
	}

	public function setHoraire(Horaire $horaire)
	{
		$this->horaire = $horaire ;
	}

	public function getHoraire()
	{
		return $this->horaire ;
	}

	public function getDebut(){ return $this->getHoraire()->getDebut(); }
	public function getFin(){ return $this->getHoraire()->getFin(); }

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
		$diff = date_diff($this->horaire->getFin(), $this->horaire->getDebut()) ; 
		$span = ($diff->h * 60 + $diff->i ) / 5 ;

		return $span ;
	}

}