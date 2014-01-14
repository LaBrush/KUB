<?php

namespace Kub\CollaborationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Kub\CollaborationBundle\Entity\Projet ;
use Kub\CollaborationBundle\Entity\Permission ;

use Kub\CollaborationBundle\Form\Type\ProjetType ;
use Kub\CollaborationBundle\Form\Handler\ProjetHandler ;

use Kub\CollaborationBundle\Entity\Fichier ;
use Kub\CollaborationBundle\Form\Type\FichierType ;
use Kub\CollaborationBundle\Form\Handler\FichierHandler ;

class FichierController extends Controller
{
	public function goAction(Projet $projet, $id){

		if(!$this->get('security.context')->isGranted('CONTRIBUTEUR', $projet))
		{
			throw new AccessDeniedException('Vous n\'avez pas les droits requis pour acceder à cet espace de collaboration');
		}

		$fichier = $this->get('doctrine.orm.entity_manager')->getRepository('KubCollaborationBundle:Fichier')->findOneById($id);

		return $this->render('KubCollaborationBundle:Fichier:go.html.twig', array(
			'fichier' => $fichier,
			'projet' => $projet
		));		
	}

	public function showAction(Projet $projet, $id){

		if(!$this->get('security.context')->isGranted('VISITEUR', $projet))
		{
			throw new AccessDeniedException('Vous n\'avez pas les droits requis pour acceder à cet espace de collaboration');
		}

		$fichier = $this->get('doctrine.orm.entity_manager')->getRepository('KubCollaborationBundle:Fichier')->findOneById($id);

		$template = 'show';
		if($request->attributes->get('_route') != 'kub_collaboration_documentheque_fichier_show' || $request->isXmlHttpRequest() )
		{
			$template .= '_content' ;
		}

		return $this->render('KubCollaborationBundle:Fichier:' . $template . '.html.twig', array(
			'fichier' => $fichier,
			'projet' => $projet
		));		
	}

	public function addAction(Projet $projet)
	{
		if(!$this->get('security.context')->isGranted('CONTRIBUTEUR', $projet))
		{
			throw new AccessDeniedException('Vous n\'avez pas les droits requis pour modifier cet espace de collaboration');
		}

		$fichier = new Fichier();
		$fichier->setDocumentheque( $projet->getDocumentheque() );

		$form = $this->createForm(new FichierType, $fichier);

		$request = $this->get('request');
		$em = $this->get('doctrine.orm.default_entity_manager');

		if($request->getMethod() == 'POST'){

			$formHandler = new FichierHandler($form, $request, $em, $this->get('security.context'), $this->get('validator'), $this->get('kub.notification_manager'));

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', 'Le Fichier a bien été mis en ligne'); 
				return $this->redirect( $this->generateUrl('kub_collaboration_documentheque_fichier_go', array(
					'slug' => $projet->getSlug(),
					"id" => $fichier->getId())) 
				);
			}
			else
			{
				$this->get('session')->getFlashBag()->add('info', 'Une erreur est survenue lors de l\'ajout du Fichier');
			}
		}

		return $this->render('KubCollaborationBundle:Fichier:create.html.twig',
			array(
				'projet' => $projet,
				'form' => $form->createView()
			)
		);  
	}

	public function editAction(Fichier $fichier)
	{
		if(!$this->get('security.context')->isGranted('CONTRIBUTEUR', $projet))
		{
			throw new AccessDeniedException('Vous n\'avez pas les droits requis pour modifier cet espace de collaboration');
		}

		if(!$this->get('security.context')->isGranted('ROLE_PROFESSEUR'))
		{
			$fichier->setValide(false);
		}

		$form = $this->createForm(new FichierType, $fichier);

		$request = $this->get('request');
		$em = $this->get('doctrine.orm.default_entity_manager');

		if($request->getMethod() == 'POST'){

			$formHandler = new FichierHandler($form, $request, $em, $this->get('security.context'), $this->get('validator'), $this->get('kub.notification_manager'));

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', 'La Fichier a bien été modifiée.'); 
				return $this->redirect( $this->generateUrl('kub_collaboration_documentheque_show', array('slug'=>$projet->getSlug())) );
			}
			else
			{
				$this->get('session')->getFlashBag()->add('info', 'Une erreur est survenue lors de la modification du Fichier');
			}
		}

		return $this->render('KubCollaborationBundle:Fichier:create.html.twig',
			array(
				'projet' => $projet,
				'form' => $form->createView()
			)
		); 
	}

	public function deleteAction(Projet $projet, Fichier $fichier)
	{
		if(!$this->get('security.context')->isGranted('CONTRIBUTEUR', $projet))
		{
			throw new AccessDeniedException('Vous n\'avez pas les droits requis pour modifier cet espace de collaboration');
		}

		$form = $this->createFormBuilder()->getForm();
		$request = $this->getRequest();

		if ($request->getMethod() == 'POST') {
			$form->bind($request);

			if ($form->isValid()) {

				$em = $this->get('doctrine.orm.default_entity_manager');
				$em->remove($fichier);
				$em->flush();

				$this->get('session')->getFlashBag()->add('info', 'Fichier supprimée');
	
				return $this->redirect( $this->generateUrl('kub_collaboration_documentheque_show', array('slug'=>$projet->getSlug())) );
			}
		}

		return $this->render('KubCollaborationBundle:Fichier:delete.html.twig', array(
			'projet' => $projet,
			'fichier' => $fichier,
			'form' => $form->createView(),
		));
	}
}
