<?php

namespace Kub\CollaborationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Kub\CollaborationBundle\Entity\Projet ;
use Kub\CollaborationBundle\Entity\Organisation ;
use Kub\CollaborationBundle\Entity\Tache ;
use Kub\CollaborationBundle\Entity\TacheListe ;

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

	public function createAction(Projet $projet)
	{
		$tache = new Tache ;
		$form = $this->createForm(new TacheType($projet), $tache);

		$request = $this->get('request');
		$em = $this->get('doctrine.orm.default_entity_manager');

		if($request->getMethod() == "POST"){

			$formHandler = new TacheHandler($form, $request, $this->get('doctrine.orm.default_entity_manager'));

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', "Le groupe a bien été ajouté");
				return $this->redirect($this->generateUrl("groupe_list"));
			}
		}

		$template = 'create';

		if($this->get('request')->attributes->get('_route') != 'kub_collaboration_organisation_index')
		{
			$template .= "_content" ; 
		}


		return $this->render('KubCollaborationBundle:Organisation:' . $template . '.html.twig',
			array(
				'form' => $form->createView(),
				'groupe' => $tache
			)
		);
	}

	public function editAction(Projet $projet, Tache $tache)
	{
		$form = $this->createForm(new TacheType($projet), $tache);

		$request = $this->get('request');
		$em = $this->get('doctrine.orm.default_entity_manager');

		if($request->getMethod() == "POST"){

			$formHandler = new TacheHandler($form, $request, $this->get('doctrine.orm.default_entity_manager'));

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', "Le groupe a bien été modifié");
				return $this->redirect($this->generateUrl("groupe_list"));
			}

		}

		return $this->render('KubCollaborationBundle:Organisation:edit.html.twig',
			array(
				'form' => $form->createView(),
				'groupe' => $tache
			)
		);
	}

	public function deleteAction(Projet $projet, Tache $tache)
	{
		$form = $this->createFormBuilder()->getForm();
		$request = $this->getRequest();

		if ($request->getMethod() == 'POST') {
			$form->bind($request);

			if ($form->isValid()) {

				$em = $this->get('doctrine.orm.default_entity_manager');
				$em->remove($tache);
				$em->flush();

				$this->get('session')->getFlashBag()->add('info', 'Groupe bien supprimé');
	
				return $this->redirect($this->generateUrl('groupe_list'));
			}
		}

		return $this->render('KubCollaborationBundle:Organisation:delete.html.twig', array(
			'groupe' => $tache,
			'form' => $form->createView(),
		));
	}

	public function showAction(Projet $projet, Tache $tache)
	{
		return $this->render("KubCollaborationBundle:Organisation:show.html.twig", 
			array(
				"groupe" => $tache
			)
		);

	}
}
