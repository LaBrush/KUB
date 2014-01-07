<?php

namespace Kub\CollaborationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Kub\CollaborationBundle\Entity\Projet ;

class DefaultController extends Controller
{
	public function indexAction()
	{
		$liste_projets = $this->get('doctrine.orm.default_entity_manager')->getRepository('KubCollaborationBundle:Projet')->findByUser($this->getUser());

		return $this->render('KubCollaborationBundle:Default:index.html.twig', array(
			'liste_projets' => $liste_projets
		));
	}
}
