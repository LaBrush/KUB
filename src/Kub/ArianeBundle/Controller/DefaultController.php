<?php

namespace Kub\ArianeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException ;

use Kub\ArianeBundle\Entity\Post ;
use Kub\ArianeBundle\Entity\Fil  ;

class DefaultController extends Controller
{
	public function indexAction($username)
	{
		if(!$this->get('security.context')->isGranted('ROLE_ARIANE'))
		{
			throw new AccessDeniedException("Vous n'avez pas accès aux fils d'ariane");
		}

		if($this->getUser()->getClass() == 'eleve')
		{
			$username = $this->getUser()->getUsername();	
		}

		$fil = $this->getDoctrine()->getManager()->getRepository('KubArianeBundle:Fil')->findByUser($username);

		return $this->render('KubArianeBundle:Default:home.html.twig', array(
			'fil' => $fil
		));
	}
}
