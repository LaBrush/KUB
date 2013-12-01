<?php

namespace Kub\RessourceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
	public function indexAction()
	{
		$ressources = $this->get('doctrine.orm.entity_manager')->getRepository('KubRessourceBundle:Ressource')->findAll();

		return $this->render('KubRessourceBundle:Default:index.html.twig', array(
			'ressources' => $ressources
		));
	}

	public function searchAction()
	{

	}

	public function addAction()
	{

	}
}
