<?php

namespace Kub\CollaborationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Kub\CollaborationBundle\Entity\Projet ;
use Kub\CollaborationBundle\Entity\Organisation ;

class OrganisationController extends Controller
{
	public function indexAction(Projet $projet)
	{
		if(!$this->get('security.context')->isGranted('VISITEUR', $projet))
		{
			throw new AccessDeniedException("Vous n'avez pas les droits requis pour acceder à cet espace de collaboration");
		}

		return $this->render('KubCollaborationBundle:Organisation:index.html.twig', array(
			'projet' => $projet
		));
	}
}
