<?php

namespace Kub\CollaborationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Kub\CollaborationBundle\Entity\Projet ;
use Kub\CollaborationBundle\Entity\Permission ;

use Kub\CollaborationBundle\Form\Type\ProjetType ;
use Kub\CollaborationBundle\Form\Handler\ProjetHandler ;

class ProjetController extends Controller
{
	public function showAction(Projet $projet)
	{	
		return $this->render('KubCollaborationBundle:Projet:show.html.twig', array(
			'projet' => $projet
		));
	}

	public function createAction()
	{
		$projet = new Projet ;
		$permission = new Permission ;
			$permission->setUser($this->getUser());
			$permission->setRole(Permission::ADMINISTRATEUR);
		$projet->addPermission($permission);

		$form = $this->createForm(new ProjetType, $projet);

		$request = $this->get('request');
		$em = $this->get('doctrine.orm.default_entity_manager');

		if($request->getMethod() == "POST"){

			$formHandler = new ProjetHandler($form, $request, $this->get('doctrine.orm.default_entity_manager'));

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', "Le projet " . $projet->getName() . " a été crée");
				return $this->redirect($this->generateUrl("kub_collaboration_show_projet", array('slug' => $projet->getSlug())));
			}

		}

		return $this->render('KubCollaborationBundle:Projet:create.html.twig',
			array(
				'form' => $form->createView(),
				'projet' => $projet
			)
		);
	}

	public function editAction(Projet $projet)
	{
		$form = $this->createForm(new ProjetType, $projet);

		$request = $this->get('request');
		$em = $this->get('doctrine.orm.default_entity_manager');

		if($request->getMethod() == "POST"){

			$formHandler = new ProjetHandler($form, $request, $this->get('doctrine.orm.default_entity_manager'));

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', "Le projet " . $projet->getName() . " a été modifié");
				return $this->redirect($this->generateUrl("kub_collaboration_show_projet", array('slug' => $projet->getSlug())));
			}

		}

		return $this->render('KubCollaborationBundle:Projet:edit.html.twig',
			array(
				'form' => $form->createView(),
				'projet' => $projet
			)
		);
	}
}
