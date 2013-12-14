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

	public function getLastHoraire(){

		$heure = key( array_slice( $this->horaires, -1, 1, TRUE ) );
			
		$minute = end($this->horaires);
		$minute = end($minute);

		$last_horaire = new \Datetime();
		$last_horaire->setTime($heure, $minute);

		return $last_horaire ;
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

	public function getHorairesOf($entity){

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

	public function getEDTOf($entity){

		$horaires = $this->getHorairesOf( $entity );
		$horaires_jours = array();

		//On genere la liste des jours
		$liste_jours = $this->getJours();
		for($i = 0 ; $i < count($liste_jours) ; $i++)
		{
			$horaires_jours[ $liste_jours[$i] ] = array();
		}

		//la liste des cours avec les fillers
		$horaires_jours_filled = $horaires_jours ;

		// on classe les cours par jour
		for($i = 0 ; $i < count($horaires) ; $i++)
		{
			$horaires_jours[ (string)$horaires[$i]->getJour() ][] = $horaires[$i] ;
		}


		ob_start();
		//On rempli les intervals pour chaque jours
		foreach($horaires_jours as $key => $horaires_jour)
		{
			$last_horaire_used = $this->getFirstHoraire();

			for($y = 0 ; $y < count($horaires_jour) ; $y++)
			{
				$interval = new Interval($horaires_jour[$y]);

				$transition = new Interval();
					$transition->link($last_horaire_used, $interval);

				//On insere la transition puis l'interval dans l'emploi du temps
				if($interval->getRowSpan() > 0){
					if($transition->getRowSpan() > 0)
					{
						$horaires_jours_filled[ $key ][] = $transition ;
					}
					$horaires_jours_filled[ $key ][] = $interval ;}

				$last_horaire_used = $interval->getHoraire()->getFin();
			}

			
		}

		foreach ($horaires_jours_filled["lundi"] as $i) {
			echo $i->getHoraire().'   ';
		}

		throw new \Exception(ob_get_clean());
		
		// // ob_clean();
	}
}

