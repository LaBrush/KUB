<?php

namespace Kub\EDTBundle\Services ;

class TimeService
{
	private $horaires ;

	public function __construct($edt)
	{
		$this->horaires = $edt["horaires"];
	}

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
}