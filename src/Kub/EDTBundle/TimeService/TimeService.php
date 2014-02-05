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

			->join('c.matiere', 'm')
			->addSelect('m')

			->join('m.categorie', 'ca')
			->addSelect('ca')

			->orderBy('h.debut')
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
				break;
			default:
				throw new \Exception("Erreur: seul les professeurs, les élèves et les groupes disposent d'emploi du temps");
				break ;
		}		

		$qb->setParameter('id', $entity->getId());

		return $qb->getQuery()->getResult();
	}

	public function getEDTOf($entity){

		$horaires_cours = $this->getHorairesOf( $entity );
		$intervals_jours = array();
		$edt = array();

		$horaires = $this->getHoraires();
		$jours = $this->getJours();


		//Les deux prochaines boucles classent les horaires par jour
		for($i = 0 ; $i < count($jours) ; $i++){

			$intervals_jours[ $jours[$i] ] = array();
		}	

		for ($i=0; $i < count($horaires_cours); $i++) { 
			
			$intervals_jours[ $horaires_cours[$i]->getJour()->getName() ][] =  $this->interval($horaires_cours[$i]);
		}


		// Ici on les insere dans l'edt par jour
		for($i = 0 ; $i < count($jours) ; $i++){

			$edt[ $jours[$i] ] = array(

				'nom' => $jours[$i],
				'intervals' => array()

			);
		}

		//Enfin on insere des fillers afin de compéter l'affichage
		foreach($intervals_jours as $jour => $intervals) { 

			$size = count($intervals) ;
			$last_horaire = $this->getFirstHoraire();

			$pos = 0 ;

			for ($y=0; $y < $size; $y++) { 

				$previous = $this->interval()->link($last_horaire, $intervals_jours[ $jour ][$y]);

				$interval = $intervals_jours[$jour][$y] ;
				$last_horaire = $interval->getHoraire()->getFin();

				if($previous->getRowSpan() > 0){  $edt[$jour]['intervals'][$pos] = $previous ; $pos++ ;}
				if($interval->getRowSpan() > 0){  $edt[$jour]['intervals'][$pos] = $interval ; $pos++ ;}

				if($interval->getHoraire()->getCours()->getMatiere()->getName() == "Mathématiques" && $interval->getHoraire()->getJour() == "jeudi"){ 
					throw new \Exception($interval->getRowSpan());
				}
			}

			$last = $this->interval()->link($last_horaire, $this->getLastHoraire());
			if( $last->getRowSpan() > 0 ){
				$edt[$jour]['intervals'][] = $last ;
			}				
		}

		return $edt ;
	}

	public function interval($horaire = null)
	{
		return new Interval($this->getHoraires(), $horaire);
	}
}
