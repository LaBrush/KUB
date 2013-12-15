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

	public function ShowEDT( $entity )
	{
		//L'edt lisible "par des humains"
		$edt = $this->time->getEDTOf( $entity );

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
