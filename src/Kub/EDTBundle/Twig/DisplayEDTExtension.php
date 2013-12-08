<?php
namespace Kub\EDTBundle\Twig;

class DisplayEDTExtension extends \Twig_Extension
{
	private $time ;

	public function __construct($time, $templating, $em)
	{
		$this->time = $time ;
		$this->templating = $templating ;
		$this->em = $em ;
	}

	public function getFunctions()
	{
		return array(
			'ShowEDT' => new \Twig_Function_Method($this, 'ShowEDT', array('is_safe' => array('html')))
		);
	}

	public function ShowEDT( $user )
	{
		$intervals_label_horaires = $this->time->getEachIntervals();
		$horaires_cours = $this->time->getEDTOf( $user );	
		$jours = $this->time->getJours();
		$intervals_cours = array();
		$tmp = array();
		$edt_base = array(); // l'edt sans les cours
		$edt = array();

		for ($i=0; $i < count($jours); $i++) { 
			$tmp[ $jours[$i] ] = array();
		}
		$jours = $tmp ;

		for ($i=0; $i < count($horaires_cours); $i++) { 
			$intervals_cours[] = $this->time->wrapHoraire( $horaires_cours[$i] );
		}

		for ($i=0; $i < count($intervals_label_horaires); $i++) { 			

			$edt_base[] = array(
				"interval" => $intervals_label_horaires[$i],
				'jours' => $jours
			);
		}

		foreach ($edt_base as $row) {
			foreach ($intervals_cours as $interval) {

				if($row['interval']->getDebut()->format('Hi') == $interval->getDebut()->format('Hi'))
				{	
					$row['jours'][ $interval->getHoraire()->getJour()->getName() ][] = $interval ;	
				}
			}

			$edt[] = $row ;
		}

		return $this->templating->render('KubEDTBundle:EDT:show.html.twig',array(

			'liste_jours' => $this->time->getJours(),
			'edt' => $edt,

		));		

	}

	public function getName()
	{
		return 'ShowEDT';
	}
}
