<?php

namespace Kub\RessourceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Kub\RessourceBundle\Entity\Ressource ;
use Kub\RessourceBundle\Form\Type\RessourceType ;
use Kub\RessourceBundle\Form\Handler\RessourceHandler ;

class SearchController extends Controller
{
	public function searchAction()
	{
		$ressource = $this->get('request')->get('ressource');
		
		if($ressource == ""){
			$this->createNotFoundException("En ne cherchant rien, on finit par trouver tout autant");
		}

		$ressources = $this->get('doctrine.orm.default_entity_manager')->getRepository("KubRessourceBundle:Ressource")->findByAll( $ressource );

		return $this->render('KubRessourceBundle:Default:index.html.twig', array(
			'ressources' => $ressources
		));

	}
}
