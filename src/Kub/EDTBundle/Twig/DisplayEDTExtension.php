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

		$edt = $this->time->getEDTOf( $user );
		$cols = count( $this->time->getJours() ) + 1 ;
		$rows =  $this->time->getIntervals() + 1 ;

		return $this->templating->render('KubEDTBundle:EDT:show.html.twig',array(

			'liste_jours' => $this->time->getJours(),
			'edt' => $edt

		));		

	}

	public function getName()
	{
		return 'ShowEDT';
	}
}
