<?php

namespace Kub\EDTBundle\TimeService ;

use Kub\EDTBundle\Entity\Horaire ;

class TimeService
{
	private $horaires ;
	private $jours ;
	private $em ;

	public function __construct($edt, $em)
	{
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

	//Fonctions sur les jours

	public function getJours(){

		return $this->jours ;
	}

	//Fonctions sur l'emplois du temps

	public function getCurrentCoursOf(Professeur $professeur){

		return $edt = $this->em->getRepository('KubUserBundle:Professeur')->getCurrentCoursOf( $professeur->getId() );
	}

	public function getEDTOf($user){

		$edt = false ;

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

		switch(get_class($user))
		{
			case "Kub\UserBundle\Entity\Eleve":
				$qb->join('g.eleves', 'e')
				   ->where('e.id = :id')
				;
				break;
			case "Kub\UserBundle\Entity\Professeur": 
				$qb->where('p.id = :id');
				break;
			default:
				throw new \Exception("Erreur: seul les professeurs et les élèves disposent d'emploi du temps");
				break ;
		}		

		$qb->setParameter('id', $user->getId());

		return $qb->getQuery()->getArrayResult();
	}

	// Fonctions sur des intervals dans l'affichage de l'emploi du temps

	//Donne l'interval d'une journée entiere
	public function getMasterInterval(){
		$horaire = new Horaire ;

		$keys = array_keys($this->horaires);

		$debut = new \Datetime();
			$debut->setTime($keys[0], $this->horaires[$keys[0]][0]);

		$fin = new \Datetime();
			$fin->setTime($keys[count($keys)-1], $this->horaires[$keys[count($keys)-1]][0]);

		$horaire->setDebut( $debut );
		$horaire->setFin( $fin );

		$journee = new Interval ;
		$journee->setHoraire($horaire);

		return $journee ;
	}

	public function getEachIntervals(){

		$liste_intervals = array();

		//On amorce la choucroute
		$last_datetime = new \Datetime();
			$keys = array_keys($this->horaires);
			$last_datetime->setTime($keys[0], $this->horaires[$keys[0]][0]);

		foreach ($this->horaires as $heures => $minutes) {
			foreach ($minutes as $minute) {
				
				$horaire = new Horaire ;
					$horaire->setDebut( $last_datetime );

					$last_datetime = new \Datetime ;
						$last_datetime->setTime($heures, $minute);
					$horaire->setFin($last_datetime);

				$interval = new Interval($horaire);

				if($interval->getRowSpan() > 0)
				{
					$liste_intervals[] = $interval ;
				}

			}
		}

		return $liste_intervals ;

	}

}

