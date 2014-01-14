<?php

namespace Kub\NoteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Kub\NoteBundle\Form\Type\ControleType ;
use Kub\NoteBundle\Form\Handler\ControleHandler; 

use Kub\UserBundle\Entity\Eleve ;
use Kub\NoteBundle\Entity\Controle ;
use Kub\NoteBundle\Entity\Note ;
use Kub\ClasseBundle\Entity\Groupe ;

class ProfesseurController extends Controller
{
	/**
	 * @Secure(roles="ROLE_PROFESSEUR")
	 */
	public function indexAction()
	{
		$liste_cours = $this->get('doctrine.orm.entity_manager')->getRepository('KubEDTBundle:Cours')->findByProfesseur( $this->getUser() );
		$liste_groupes = array();

		foreach ($liste_cours as $cours) {
			foreach ($cours->getGroupes() as $groupe) {
				if(!in_array($groupe, $liste_groupes))
				{
					$liste_groupes[] = $groupe ;
				}
			}
		}

		return $this->render('KubNoteBundle:Professeur:index.html.twig', array(
			'liste_cours' => $liste_cours,
			'liste_groupes' => $liste_groupes
		));
	}
		
	/**
	 * @Secure(roles="ROLE_PROFESSEUR")
	 */
	public function noterGroupeAction($cours)
	{
		$cours = $this->get('doctrine.orm.entity_manager')->getRepository('KubEDTBundle:Cours')->findOneById( $cours );

		$controle = new controle ;
		$controle->setCours( $cours );

		$eleves = array();

		foreach ($cours->getGroupes() as $groupe) { $eleves = array_merge($eleves, $groupe->getEleves()->toArray() ); }

		foreach ($eleves as $eleve) {

			if(!$controle->hasEleve($eleve))
			{
				$absence = new Note ;
				$absence->setEleve( $eleve );

				$controle->addNote( $absence );
			}

		}

		$form  = $this->createForm(new ControleType( $cours->getProfesseur(), $cours ), $controle, 
			array(
				'action' => $this->generateUrl('kub_notes_professeur_homepage', array('cours' => $cours->getId()))
			)
		);

		$request = $this->get('request');
		if($request->getMethod() == "POST"){

			$formHandler = new ControleHandler($form, $request, $this->get('doctrine.orm.default_entity_manager'), $this->get('kub.notification_manager'));

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', "Le controle a bien été ajouté");

				return $this->redirect($this->generateUrl("home_homepage"));
			}
			else
			{
				$this->get('session')->getFlashBag()->add('info', "Une erreur est survenue lors de l'ajout du controle");   
			}

		}

		return $this->render('KubNoteBundle:Professeur:noter.html.twig', array(
			'form' => $form->createView(),
			'cours' => $cours
		)); 
	}

	/**
	 * @Secure(roles="ROLE_PROFESSEUR")
	 */
	public function editAction($id)
	{
		$controle = $this->get('doctrine.orm.default_entity_manager')->getRepository('KubNoteBundle:Controle')->findOneById($id);

		$eleves = array();
		$cours = $controle->getCours();

		foreach ($cours->getGroupes() as $groupe) { $eleves = array_merge($eleves, $groupe->getEleves()->toArray() ); }

		foreach ($eleves as $eleve) {

			if(!$controle->hasEleve($eleve))
			{
				$absence = new Note ;
				$absence->setEleve( $eleve );

				$controle->addNote( $absence );
			}

		}

		$form  = $this->createForm(new ControleType( $cours->getProfesseur(), $cours ), $controle, 
			array(
				'action' => $this->generateUrl('kub_notes_professeur_edit', array('id' => $controle->getId()))
			)
		);

		$request = $this->get('request');
		if($request->getMethod() == "POST"){

			$formHandler = new ControleHandler($form, $request, $this->get('doctrine.orm.default_entity_manager'), $this->get('kub.notification_manager'));

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', "Le controle a bien été ajouté");
				return $this->redirect($this->generateUrl("home_homepage"));
			}
			else
			{
				$this->get('session')->getFlashBag()->add('info', "Une erreur est survenue lors du controle");   
			}

		}

		return $this->render('KubNoteBundle:Professeur:noter.html.twig', array(
			'form' => $form->createView(),
			'cours' => $cours
		)); 
	}

	/**
	 * @Secure(roles="ROLE_PROFESSEUR")
	 */
	public function listAction(Groupe $groupe)
	{
		$controles = $this->get('doctrine.orm.default_entity_manager')->getRepository('KubNoteBundle:Controle')->findByProfesseurAndGroupe($this->getUser(), $groupe);

		return $this->render('KubNoteBundle:Groupe:list_content.html.twig',array(
			'controles' => $controles
		));
	}

	/**
	 * @Secure(roles="ROLE_PROFESSEUR")
	 */
	public function showAction($id)
	{
		$controle = $this->get('doctrine.orm.default_entity_manager')->getRepository('KubNoteBundle:Controle')->findOneById( $id );

		return $this->render('KubNoteBundle:Groupe:show.html.twig',array(
			'controle' => $controle
		));
	}

	/**
	 * @Secure(roles="ROLE_PROFESSEUR")
	 */
	public function deleteAction(Controle $controle)
	{
		$form = $this->createFormBuilder(null, array(
			'action' => $this->generateUrl('kub_notes_professeur_delete', 
				array(
					'note' => $controle->getId()
			))
		))->getForm();

		$request = $this->getRequest();

		if ($request->getMethod() == 'POST') {
			
			if($controle->getProfesseur() != $this->getUser())
			{
				throw new AccessDeniedException("Vous n'êtes pas autorisé à supprimer cette note");
			}

			$form->bind($request);

			if ($form->isValid()) {

				$em = $this->get('doctrine.orm.default_entity_manager');
				$em->remove($controle);
				$em->flush();
		
				$this->get('session')->getFlashBag()->add('info', "La note a été supprimée");

				return $this->redirect($this->generateUrl('user_show', array('role'=> $controle->getEleve()->getClass(), 'username'=> $controle->getEleve()->getUsername()) ));
			}
		}

		return $this->render('KubNoteBundle:Professeur:delete.html.twig',
			array(
				'form' => $form->createView(),
				'note' => $controle
			)
		);
	}

	public function showEleveAction(Eleve $user)
	{
		$notes = $this->get('doctrine.orm.entity_manager')->getRepository('KubNoteBundle:Note')->findByUsername( $user->getUsername() );
		$moyennes = $this->get('doctrine.orm.entity_manager')->getRepository('KubNoteBundle:Note')->findMoyennesFor( $user->getUsername() );

		$matieres = array();

		for ($i=0; $i < count($notes) ; $i++) { 
			if(!isset($matieres[ $notes[$i]['matiere'] ])) {
				$matieres[ $notes[$i]['matiere'] ] = array();	
			}

			$matieres[ $notes[$i]['matiere'] ][] = $notes[$i]['note'] ;
		}						

		return $this->render('KubNoteBundle:Professeur:show_eleve.html.twig',
			array(
				'matieres' => $matieres,
				'moyennes' => $moyennes,
				'eleve' => $user
			)
		);   

	}
}
