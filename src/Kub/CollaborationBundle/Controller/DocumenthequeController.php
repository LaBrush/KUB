<?php

namespace Kub\CollaborationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Kub\CollaborationBundle\Entity\Projet ;
use Kub\CollaborationBundle\Entity\Permission ;

use Kub\CollaborationBundle\Form\Type\ProjetType ;
use Kub\CollaborationBundle\Form\Handler\ProjetHandler ;

class DocumenthequeController extends Controller
{
	public function indexAction(Projet $projet)
	{	
		if(!$this->get('security.context')->isGranted('VISITEUR', $projet))
		{
			throw new AccessDeniedException("Vous n'avez pas les droits requis pour acceder à cet espace de collaboration");
		}

		return $this->render('KubCollaborationBundle:Documentheque:index.html.twig', array(
			'projet' => $projet
		));
	}
}
