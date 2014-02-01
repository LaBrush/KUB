<?php

namespace Kub\CollaborationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Kub\CollaborationBundle\Entity\Projet ;
use Kub\CollaborationBundle\Entity\Permission ;

use Kub\CollaborationBundle\Form\Type\ProjetType ;
use Kub\CollaborationBundle\Form\Handler\ProjetHandler ;

use Kub\CollaborationBundle\Entity\Ressource ;
use Kub\CollaborationBundle\Form\Type\RessourceType ;
use Kub\CollaborationBundle\Form\Handler\RessourceHandler ;

class RessourceController extends Controller
{
	public function showAction(Projet $projet, $id){

		if(!$this->get('security.context')->isGranted('VISITEUR', $projet))
		{
			throw new AccessDeniedException('Vous n\'avez pas les droits requis pour acceder à cet espace de collaboration');
		}

		$ressource = $this->get('doctrine.orm.entity_manager')->getRepository('KubCollaborationBundle:Ressource')->findOneById($id);
		$template = 'show';

		$request = $this->get('request');

		if($request->attributes->get('_route') != 'kub_collaboration_documentheque_ressource_show' || $request->isXmlHttpRequest() )
		{
			$template .= '_content' ;
		}

		return $this->render('KubCollaborationBundle:Ressource:' . $template . '.html.twig', array(
			'ressource' => $ressource,
			'projet' => $projet
		));		
	}

	public function addAction(Projet $projet)
	{
		if(!$this->get('security.context')->isGranted('CONTRIBUTEUR', $projet))
		{
			throw new AccessDeniedException('Vous n\'avez pas les droits requis pour modifier cet espace de collaboration');
		}

		$ressource = new Ressource();
		$ressource->setDocumentheque( $projet->getDocumentheque() );

		$form = $this->createForm(new RessourceType, $ressource);

		$request = $this->get('request');
		$em = $this->get('doctrine.orm.default_entity_manager');

		if($request->getMethod() == 'POST'){

			$formHandler = new RessourceHandler($form, $request, $em, $this->get('security.context'), $this->get('validator'), $this->get('kub.notification_manager'));

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', 'La ressource a bien été mise en ligne'); 
				return $this->redirect( $this->generateUrl('kub_collaboration_documentheque_show', array('slug'=>$projet->getSlug())) );
			}
			else
			{
				$this->get('session')->getFlashBag()->add('info', 'Une erreur est survenue lors de l\'ajout de la ressource');
			}
		}

		return $this->render('KubCollaborationBundle:Ressource:create.html.twig',
			array(
				'projet' => $projet,
				'form' => $form->createView(),
				'ressource' => $ressource
			)
		);  
	}

	public function editAction(Projet $projet, Ressource $ressource)
	{
		if(!$this->get('security.context')->isGranted('CONTRIBUTEUR', $projet))
		{
			throw new AccessDeniedException('Vous n\'avez pas les droits requis pour modifier cet espace de collaboration');
		}

		$form = $this->createForm(new RessourceType, $ressource);

		$request = $this->get('request');
		$em = $this->get('doctrine.orm.default_entity_manager');

		if($request->getMethod() == 'POST'){

			$formHandler = new RessourceHandler($form, $request, $em, $this->get('security.context'), $this->get('validator'), $this->get('kub.notification_manager'));

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', 'La ressource a bien été modifiée.'); 
				return $this->redirect( $this->generateUrl('kub_collaboration_documentheque_show', array('slug'=>$projet->getSlug())) );
			}
			else
			{
				$this->get('session')->getFlashBag()->add('info', 'Une erreur est survenue lors de la modification de la ressource');
			}
		}

		return $this->render('KubCollaborationBundle:Ressource:create.html.twig',
			array(
				'projet' => $projet,
				'form' => $form->createView(),
				'ressource' => $ressource
			)
		); 
	}

	public function deleteAction(Projet $projet, Ressource $ressource)
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
				$em->remove($ressource);
				$em->flush();

				$this->get('session')->getFlashBag()->add('info', 'Ressource supprimée');
	
				return $this->redirect( $this->generateUrl('kub_collaboration_documentheque_show', array('slug'=>$projet->getSlug())) );
			}
		}

		return $this->render('KubCollaborationBundle:Ressource:delete.html.twig', array(
			'projet' => $projet,
			'ressource' => $ressource,
			'form' => $form->createView(),
		));
	}
}
