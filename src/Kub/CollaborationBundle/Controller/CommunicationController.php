<?php

namespace Kub\CollaborationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Kub\CollaborationBundle\Entity\Projet ;
use Kub\CollaborationBundle\Entity\Communication ;
use Kub\CollaborationBundle\Entity\Sujet ;
use Kub\CollaborationBundle\Entity\Post ;

use Kub\CollaborationBundle\Form\Type\SujetType ;
use Kub\CollaborationBundle\Form\Handler\SujetHandler ;

class CommunicationController extends Controller
{
	public function indexAction(Projet $projet)
	{
		if(!$this->get('security.context')->isGranted('VISITEUR', $projet))
		{
			throw new AccessDeniedException('Vous n\'avez pas les droits requis pour acceder à cet espace de collaboration');
		}

		return $this->render('KubCollaborationBundle:Communication:index.html.twig', array(
			'projet' => $projet
		));
	}

	/**
 	 * @ParamConverter("projet", options={"mapping": {"projet_slug": "slug"}})
 	 * @ParamConverter("sujet",  options={"mapping": {"tache_slug":  "slug"}})
	 */
	public function showAction(Projet $projet, Sujet $sujet)
	{
		if(!$this->get('security.context')->isGranted('VISITEUR', $projet))
		{
			throw new AccessDeniedException('Vous n\'avez pas les droits requis pour acceder à cet espace de collaboration');
		}
	}

	public function createAction(Projet $projet, Sujet $sujet)
	{
		if(!$this->get('security.context')->isGranted('CONTRIBUTEUR', $projet))
		{
			throw new AccessDeniedException('Vous n\'avez pas les droits requis pour acceder à cet espace de collaboration');
		}

		if($sujet == null)
		{
			$sujet = new Sujet ;
			$sujet->setCommunication( $projet->getCommunication() );
		}

		$form = $this->createForm(new SujetType, $groupe);

		$request = $this->get('request');
		$em = $this->get('doctrine.orm.default_entity_manager');

		if($request->getMethod() == "POST"){

			// $formHandler = new SujetHandler($form, $request, $this->get('doctrine.orm.default_entity_manager'));

			// if($formHandler->process())
			// {
			// 	$this->get('session')->getFlashBag()->add('info', "Le groupe a bien été ajouté");
			// 	return $this->redirect($this->generateUrl("groupe_list"));
			// }

		}

		return $this->render('KubClasseBundle:Groupe:create.html.twig',
			array(
				'form' => $form->createView(),
				'groupe' => $groupe
			)
		);

	}

	/**
 	 * @ParamConverter("projet", options={"mapping": {"projet_slug": "slug"}})
 	 * @ParamConverter("sujet",  options={"mapping": {"tache_slug":  "slug"}})
	 */
	public function editAction(Projet $projet, Sujet $sujet)
	{
		if(!$this->get('security.context')->isGranted('CONTRIBUTEUR', $projet))
		{
			throw new AccessDeniedException('Vous n\'avez pas les droits requis pour acceder à cet espace de collaboration');
		}
	}

	/**
 	 * @ParamConverter("projet", options={"mapping": {"projet_slug": "slug"}})
 	 * @ParamConverter("sujet",  options={"mapping": {"tache_slug":  "slug"}})
	 */
	public function deleteAction(Projet $projet, Sujet $sujet)
	{
		if(!$this->get('security.context')->isGranted('CONTRIBUTEUR', $projet))
		{
			throw new AccessDeniedException('Vous n\'avez pas les droits requis pour acceder à cet espace de collaboration');
		}
	}
}
