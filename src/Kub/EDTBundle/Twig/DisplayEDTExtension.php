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
		$horaires = $this->time->getEDTOf( $user );
		$cols = count( $this->time->getJours() ) ;
		// $rows =  $this->time->getMasterInterval()->getRowSpan() ;
		$jours = $this->time->getJours();
		$intervals = $this->time->getEachIntervals();

		$edt = array();

		$edt_jours = array();
		for ($i=0; $i < count($jours); $i++) { 
			$edt_jours[ $jours[$i] ] = array();
		}

		for ($i=0; $i < count($intervals); $i++) { 
			$edt[] = array(

				"interval" => $intervals[$i],
				// "jours" => $edt_jours

			);
		}

		//On rempli avec les horaires
		// foreach($horaires as $horaire)
		// {
		// 	$edt[ $horaire["jour"]["name"] ][] = $horaire ;
		// }

		return $this->templating->render('KubEDTBundle:EDT:show.html.twig',array(

			'liste_jours' => $this->time->getJours(),
			'edt' => $edt,
			'cols' => $cols,
			// 'rows' => $rows,
			'intervals' => $intervals

		));		

	}

	public function getName()
	{
		return 'ShowEDT';
	}
}
