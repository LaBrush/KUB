<?php

namespace Kub\EDTBundle\Services ;

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

		foreach ($this->horaires as $key => $horaire) {
			
			foreach ($horaire as $heure => $minutes) {

				$liste_heures[] = $heure ;
				
			}

		}

		return $liste_heures ;
	}

	public function getMinutes(){
		
		$liste_minutes = array() ;

		foreach ($this->horaires as $key => $horaire) {
			
			foreach ($horaire as $heure => $minutes) {

				$liste_minutes = array_merge($liste_minutes, $minutes) ;
				
			}

		}

		sort($liste_minutes);

		return $liste_minutes;
	}

	public function getMinutesForHour($hour){

		foreach ($this->horaires as $key => $horaire) {
			
			foreach ($horaire as $heure => $minutes) {
				
				if($heure == $hour)
				{
					return $horaire[$heure] ;
				}
			}
		}		

		return array();
	}

	//Fonctions sur les jours

	public function getJours(){

		return $this->jours ;
	}

	//Fonctions sur l'emplois du temps

	public function getEDTOf($user){

		$edt = false ;

		switch(get_class($user))
		{
			case "Kub\UserBundle\Entity\Eleve": 
				$edt = $this->em->getRepository('KubUserBundle:Eleve')->getEDTByid( $user->getId() );
				$edt = $this->mergeEDT( $edt );
				break;
			case "Kub\UserBundle\Entity\Professeur": 
				$edt = $this->em->getRepository('KubUserBundle:Professeur')->getEDTByid( $user->getId() );
				break;
		}

		return $edt;
	}

	public function mergeEDT($user)
	{
		$edt = array();

		foreach ($user->getGroupes() as $key => $groupe) {
			foreach ($groupe->getCours() as $key => $cours) {
				$edt = array_merge($edt, $cours->getHoraires()->toArray());
			}
		}

		return $edt ;
	}
}

