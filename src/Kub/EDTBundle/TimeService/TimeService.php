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
	public function getHoraires(){

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

			->orderBy('h.debut, j.id')
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

		$horaires_cours = $this->getHorairesOf( $entity );
		$edt = array();
		$last_cours_day = array();

		$horaires = $this->getHoraires();
		$jours = $this->getJours();

		for ($i=0; $i < count($horaires)-1 ; $i++) { 
			$edt[$i] = array( 
				"horaire" => $horaires[$i],
				"jours" => array()
			);
		}	

		$last_horaire_used = $this->getFirstHoraire();
		for ($x=0; $x < count($horaires)-1 ; $x++) { 
			for ($y=0; $y < count($jours); $y++) { 
				
				for ($z=0; $z < count($horaires_cours); $z++) { 
					$current_horaire = $horaires_cours[$z];

					if(
						$current_horaire->getJour()->getName() == $jours[$y] && 
						$current_horaire->getDebut()->format('Hi') == $horaires[$x]->format('Hi')
					){
						$transition = $this->interval((new Horaire())->setDebut($last_horaire_used)->setFin($current_horaire->getDebut())) ;
						if($transition->getRowSpan() > 0)
						{
							$edt[ $x - $transition->getRowSpan() ]['jours'][ $y ] = $transition ;
						}

						$edt[ $x ]['jours'][ $y ] = $this->interval($current_horaire);
						$last_horaire_used = $current_horaire ;

						if(!isset($last_cours_day[$y]) || $last_cours_day[$y] < $x){ $last_cours_day[$y] = $x ; }
					}

				}
				if(!isset($edt[$x]['jours'][$y])){ $edt[$x]['jours'][$y] = null; }

			}
		}


		ob_start();
		$jours_keys = array_keys($this->getJours());
		for ($i=0; $i < count($jours_keys) ; $i++) { 
			if(!isset($last_cours_day[$i])){ 
				$last_cours_day[$i] = -1;
			}
		}
		
		// print_r(array_keys($last_cours_day));

		// on ajoute un filler en fin de journée
		for ($y=0; $y < count($last_cours_day); $y++) {

			$x = $last_cours_day[$y];
			$interval = null ;

			if($x >= 0)
			{
				$interval = $edt[ $x ]['jours'][$y];
				if($interval->getRowSpan() > 0)
				{
					$edt[$x + $interval->getRowSpan()]['jours'][$y] = $this->interval(
						(new Horaire)
							->setDebut($interval->getFin())
							->setFin($this->getLastHoraire())
					);
				}
			}
			else
			{
				$edt[0]['jours'][$y] = $interval = $this->interval(
					(new Horaire)
						->setDebut($this->getFirstHoraire())
						->setFin($this->getLastHoraire())
				);
			}

			echo $interval->getHoraire() . ' ';
			
		}

		// for ($y=0; $y < count($last_cours_day); $y++) {

		// 	$x = $last_cours_day[$y];
		// 	// var_dump($edt[$x]['jours'][$y]) ;
		// 	echo $y;
		// }
		ob_clean();
		// throw new \Exception(ob_get_clean());

		return $edt ;
	}

	public function interval($horaire = null)
	{
		return new Interval($this->getHoraires(), $horaire);
	}
}

