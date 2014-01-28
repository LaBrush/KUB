<?php

namespace Kub\CollaborationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Kub\CollaborationBundle\Entity\Projet ;
use Kub\CollaborationBundle\Entity\Organisation ;
use Kub\CollaborationBundle\Entity\ListeTaches ;
use Kub\CollaborationBundle\Entity\Tache ;

use Kub\CollaborationBundle\Form\Type\TacheType ;
use Kub\CollaborationBundle\Form\Handler\TacheHandler ;

class OrganisationController extends Controller
{
	public function indexAction(Projet $projet)
	{
		if(!$this->get('security.context')->isGranted('VISITEUR', $projet))
		{
			throw new AccessDeniedException('Vous n\'avez pas les droits requis pour acceder à cet espace de collaboration');
		}

		return $this->render('KubCollaborationBundle:Organisation:index.html.twig', array(
			'projet' => $projet
		));
	}

	public function createAction(Projet $projet)
	{
		$tache = new Tache ;
		$form = $this->createForm(new TacheType($projet), $tache, array(
			'action' => $this->generateUrl('kub_collaboration_organisation_create', array('slug' => $projet->getSlug()))
		));
		
		$request = $this->get('request');
		$em = $this->get('doctrine.orm.default_entity_manager');

		if($request->getMethod() == 'POST'){

			$formHandler = new TacheHandler($form, $request, $this->get('doctrine.orm.default_entity_manager'), $projet->getOrganisateur());

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', 'La tache a bien été ajouté');
				return $this->redirect($this->generateUrl('kub_collaboration_organisation_index', array('slug' => $projet->getSlug()) ));
			}
		}

		$template = 'create';

		if($this->get('request')->attributes->get('_route') != 'kub_collaboration_organisation_create')
		{
			$template .= '_content' ; 
		}


		return $this->render('KubCollaborationBundle:Organisation:' . $template . '.html.twig',
			array(
				'projet' => $projet,
				'form' => $form->createView(),
				'tache' => $tache
			)
		);
	}

	/**
 	 * @ParamConverter("projet", options={"mapping": {"projet_slug": "slug"}})
 	 * @ParamConverter("tache",  options={"mapping": {"tache_slug":  "slug"}})
	 */
	public function showAction(Projet $projet, Tache $tache)
	{
		return $this->render('KubCollaborationBundle:Organisation:show.html.twig', 
			array(
				'projet' => $projet,
				'tache' => $tache
			)
		);
	}

	/**
 	 * @ParamConverter("projet", options={"mapping": {"projet_slug": "slug"}})
 	 * @ParamConverter("tache",  options={"mapping": {"tache_slug":  "slug"}})
	 */
	public function editAction(Projet $projet, Tache $tache)
	{
		$form = $this->createForm(new TacheType($projet), $tache);

		$request = $this->get('request');
		$em = $this->get('doctrine.orm.default_entity_manager');

		if($request->getMethod() == 'POST'){

			$formHandler = new TacheHandler($form, $request, $this->get('doctrine.orm.default_entity_manager'), $projet->getOrganisateur());

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', 'La tache a bien été modifié');
				return $this->redirect($this->generateUrl('kub_collaboration_organisation_index', array('slug' => $projet->getSlug()) ));
			}

		}

		return $this->render('KubCollaborationBundle:Organisation:edit.html.twig',
			array(
				'projet' => $projet,
				'tache' => $tache,
				'form' => $form->createView()
			)
		);
	}

	/**
 	 * @ParamConverter("projet", options={"mapping": {"projet_slug": "slug"}})
 	 * @ParamConverter("tache",  options={"mapping": {"tache_slug":  "slug"}})
	 */
	public function deleteAction(Projet $projet, Tache $tache)
	{
		$form = $this->createFormBuilder()->getForm();
		$request = $this->getRequest();

		if ($request->getMethod() == 'POST') {
			$form->bind($request);

			if ($form->isValid()) {

				$listeTaches = $tache->getListeTaches();
				$listeTaches->removeTache($tache);

				$em = $this->get('doctrine.orm.default_entity_manager');
				
				if(count($listeTaches->getTaches()) == 0){ $em->remove($listeTaches); }
				$em->remove($tache);
				
				$em->flush();
				$this->get('session')->getFlashBag()->add('info', 'Tache bien supprimée');
	
				return $this->redirect($this->generateUrl('kub_collaboration_organisation_index', array('slug' => $projet->getSlug()) ));
			}
		}

		return $this->render('KubCollaborationBundle:Organisation:delete.html.twig', array(
			'projet' => $projet,
			'tache' => $tache,
			'form' => $form->createView()
		));
	}

	public function setUserParticipeAction()
	{
		$request = $this->get('request');
		$em = $this->get('doctrine.orm.entity_manager');

		$id = $request->request->get('id');
		$participe = $request->request->get('participe');

		$tache = $em->getRepository('KubCollaborationBundle:Tache')->findOneById($id);	
		$projet = $tache ? $tache->getListeTaches()->getOrganisateur()->getProjet() : false;

		if(!$this->get('security.context')->isGranted('CONTRIBUTEUR', $projet) || !$projet || !$request->isXmlHttpRequest())
		{
			throw $this->createNotFoundException('La page recherchée n\'existe pas');
		}

		if((bool)$participe)
		{
			$tache->addParticipant( $this->getUser()) ;
		}
		else
		{
			$tache->removeParticipant( $this->getUser()) ;
		}

		$em->persist($tache);
		$em->flush();

		return new Response( $tache->getParticipantsAsString($this->getUser()) );
	}

	public function setTaskCheckedAction()
	{
		$request = $this->get('request');
		$em = $this->get('doctrine.orm.entity_manager');

		$id = $request->request->get('id');
		$checked = $request->request->get('checked');

		$tache = $em->getRepository('KubCollaborationBundle:Tache')->findOneById($id);	
		$projet = $tache ? $tache->getListeTaches()->getOrganisateur()->getProjet() : false;

		if(!$this->get('security.context')->isGranted('CONTRIBUTEUR', $projet) || !$projet || !$request->isXmlHttpRequest())
		{
			throw $this->createNotFoundException('La page recherchée n\'existe pas');
		}

		$tache->setDone( (bool)$checked );

		$em->persist($tache);
		$em->flush();

		return new Response("OK");
	}
}
