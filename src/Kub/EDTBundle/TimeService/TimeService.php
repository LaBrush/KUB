<?php

namespace Kub\EDTBundle\TimeService ;

use Kub\EDTBundle\Entity\Horaire ;
use Kub\EDTBundle\Entity\Jour ;

class TimeService
{
	private $horaires ;
	private $jours ;
	private $em ;

	public function __construct($edt, $em){
		$this->horaires = $edt["horaires"];
		$this->jours = $edt["jours"];		

		$this->em = $em;
	}

	//Fonctions sur les horaires

	public function getHours(){

		$liste_heures = array();

		foreach ($this->horaires as $heure => $minutes) {
			
				$liste_heures[] = $heure ;

		}

		return $liste_heures ;
	}

	public function getMinutes(){
		
		$liste_minutes = array() ;

		foreach ($this->horaires as $horaire => $minutes) {

				$liste_minutes = array_merge($liste_minutes, $minutes) ;
		}

		sort($liste_minutes);
		array_unique($liste_minutes);

		return $liste_minutes;
	}

	public function getMinutesForHour($asked){

		foreach ($this->horaires as $heure => $minutes) {
				
			if($heure == $asked)
			{
				return $this->horaires[$heure] ;
			}
		}		

		return array();
	}

	public function getFirstHoraire(){

		$horaire = new \Datetime ;
		$keys = array_keys($this->horaires);
		$horaire->setTime($keys[0], $this->horaires[$keys[0]][0]);

		return $horaire ;

	}

	//Renvoi un tableau contenant des Datime avec tous les horaires
	public function getHoursMinutes(){

		$horaires = array() ;

		foreach ($this->horaires as $horaire => $minutes) {
			foreach ($minutes as $minute) {
				$horaires[] = (new \Datetime)->setTime($horaire, $minute) ;
			}
		}

		sort($horaires);

		return $horaires;

	}

	//Fonctions sur les jours

	public function getJours(){

		return $this->jours ;
	}

	//Fonctions sur l'emplois du temps

	public function getCurrentCoursOf(Professeur $professeur){

		return $edt = $this->em->getRepository('KubUserBundle:Professeur')->getCurrentCoursOf( $professeur->getId() );
	}

	public function getEDTOf($entity){

		$qb = $this->em
			->createQueryBuilder()
			->select('h')
			->from('Kub\EDTBundle\Entity\Horaire', 'h')
			
			->join('h.cours', 'c')
			->addSelect('c')
			
			->join('c.groupes', 'g')
			->addSelect('g')

			->join('c.professeur', 'p')
			->addSelect('p')

			->join('h.jour', 'j')
			->addSelect('j')

			->orderBy('j.id, h.debut')
		;

		switch(get_class($entity))
		{
			case "Kub\UserBundle\Entity\Eleve":
				$qb->join('g.eleves', 'e')
				   ->where('e.id = :id')
				;
				break;
			case "Kub\UserBundle\Entity\Professeur": 
				$qb->where('p.id = :id');
				break;
			case 'Kub\ClasseBundle\Entity\Groupe':
				$qb->where('g.id = :id');
			default:
				throw new \Exception("Erreur: seul les professeurs, les élèves et les groupes disposent d'emploi du temps");
				break ;
		}		

		$qb->setParameter('id', $entity->getId());

		return $qb->getQuery()->getResult();
	}

	// Fonctions sur des intervals dans l'affichage de l'emploi du temps

	// Donne tous les intervals d'une journée
	public function getEachIntervals(){

		$liste_intervals = array();

		//On amorce la choucroute
		$last_datetime = $this->getFirstHoraire();

		foreach ($this->horaires as $heures => $minutes) {
			// foreach ($minutes as $minute) {
			for ($i=0; $i < count($minutes) ; $i++) { 
				
				$horaire = new Horaire ;
					$horaire->setDebut( $last_datetime );

					$last_datetime = new \Datetime ;
						$last_datetime->setTime($heures, $minutes[$i]);
					$horaire->setFin($last_datetime);

				$interval = new Interval($this->getHoursMinutes(),$horaire);

				if($interval->getRowSpan() > 0)
				{
					$link = (new Interval($this->getHoursMinutes()))->link( $last_datetime, $interval );
					if($link->getRowSpan() > 0)
					{
						$liste_intervals[] = $link ;
					}

					$liste_intervals[] = $interval ;
				}
			}

		//le dernier horaire de la semaine
		$last_horaire = new \Datetime();

		$heure = key( array_slice( $this->horaires, -1, 1, TRUE ) );
		
		$minute = end($this->horaires);
		$minute = end($minute);

		$last_horaire->setTime($heure, $minute);

		$filler = new Interval($this->getHoursMinutes());
		$last_horaire = count($liste_intervals) ? $liste_intervals[ count($liste_intervals)-1 ]->getHoraire()->getFin() : $this->getFirstHoraire(); ;
		$filler->link($last_datetime, $last_horaire);
		

		if($filler->getRowSpan() > 0)
		{
			$liste_intervals[] = $filler ;
		}
		}

		return $liste_intervals ;
	}

	//Converti un horaire un interval
	public function wrapHoraire(Horaire $horaire = null)
	{
		return new Interval($this->getHoursMinutes(), $horaire );
	}

}

