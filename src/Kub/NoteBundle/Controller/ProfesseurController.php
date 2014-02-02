<?php

namespace Kub\NoteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Response;

use Kub\NoteBundle\Form\Type\ControleType ;
use Kub\NoteBundle\Form\Handler\ControleHandler; 

use Kub\NoteBundle\Form\Type\NoteEleveType ;
use Kub\NoteBundle\Form\Handler\NoteEleveHandler; 

use Kub\UserBundle\Entity\Eleve ;
use Kub\NoteBundle\Entity\Controle ;
use Kub\NoteBundle\Entity\Note ;
use Kub\ClasseBundle\Entity\Groupe ;
use Kub\EDTBundle\Entity\Cours ;

class ProfesseurController extends Controller
{
	/**
	 * @Secure(roles="ROLE_PROFESSEUR")
	 */
	public function indexAction()
	{
		$liste_cours = $this->get('doctrine.orm.entity_manager')->getRepository('KubEDTBundle:Cours')->findByProfesseur( $this->getUser() );
		$liste_groupes = array();
		$liste_controles = array();

		foreach ($liste_cours as $cours) {
			foreach ($cours->getGroupes() as $groupe) {
				if(!in_array($groupe, $liste_groupes))
				{
					$liste_groupes[] = $groupe ;
				}
			}
		}

		foreach ($cours->getControles() as $controle) {
			if($controle->getProfesseur() == $this->getUser())
			{
				$liste_controles[] = $controle ;
			}
		}

		return $this->render('KubNoteBundle:Professeur:index.html.twig', array(
			'liste_cours' => $liste_cours,
			'liste_groupes' => $liste_groupes,
			'liste_controles' => $liste_controles
		));
	}
	
	/**
	 * @Secure(roles="ROLE_PROFESSEUR")
	 */
	public function noterCoursAction(Cours $cours)
	{
		$controle = new controle ;
		$controle->setCours( $cours );

		$eleves = array();

		foreach ($cours->getGroupes() as $groupe) { $eleves = array_merge($eleves, $groupe->getEleves()->toArray() ); }

		foreach ($eleves as $eleve) {

			if(!$controle->hasEleve($eleve))
			{
				$note = new Note ;
				$note->setEleve( $eleve );

				$controle->addNote( $note );
			}

		}

		$form  = $this->createForm(new ControleType( $cours->getProfesseur(), $cours ), $controle, 
			array(
				'action' => $this->generateUrl('kub_notes_professeur_noter_cours', array('cours' => $cours->getId()))
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
	public function noterGroupeAction($groupe_id)
	{
		$liste_cours = $this->get('doctrine.orm.entity_manager')->getRepository('KubEDTBundle:Cours')->findByGroupeIdAndProfesseurId( $groupe_id, $this->getUser()->getId() );

		if(count($liste_cours) == 1)
		{
			return $this->forward('KubNoteBundle:Professeur:noterCours', array(
				'cours' => $liste_cours[0]
			));	
		}
		elseif (count($liste_cours) == 0) {
			throw $this->createNotFoundException('Vous n\'avez pas cours avec ce groupe');
		}
		else
		{
			$groupe = null ;
			$liste_groupes = $liste_cours[0]->getGroupes();
			
			for ($i=0; $i < count($liste_groupes) ; $i++) { 
				if($groupe_id == $liste_groupes[$i]->getId())
				{
					$groupe = $liste_groupes[$i];
					break ;
				}
			}

			return $this->render('KubNoteBundle:Professeur:choose_cours.html.twig', array(
				'groupe' => $groupe,
				'liste_cours' => $liste_cours
			)); 	
		}
	}

	/**
	 * @Secure(roles="ROLE_PROFESSEUR")
	 */
	public function noterEleveAction($eleve)
	{
		$em = $this->get('doctrine.orm.entity_manager');

		$eleve = $em->getRepository('KubUserBundle:Eleve')->findOneByUsername($eleve);
		$controles = $em->getRepository('KubNoteBundle:Controle')->findOneByUserGroupsAndProfesseur($eleve, $this->getUser());

		$note = new Note ;
		$note->setEleve($eleve);

		$form  = $this->createForm(new NoteEleveType($controles, $eleve, $this->getUser()), $note);

		$request = $this->get('request');
		if($request->getMethod() == "POST"){

			$formHandler = new NoteEleveHandler($form, $request, $this->get('doctrine.orm.default_entity_manager'), $this->get('kub.notification_manager'));

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

		return $this->render('KubNoteBundle:Professeur:noter_eleve.html.twig', array(
			'form' => $form->createView(),
			'eleve' => $eleve
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
				$note = new Note ;
				$note->setEleve( $eleve );

				$controle->addNote( $note );
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

	/**
	 * @Secure(roles="ROLE_PROFESSEUR")
	 */
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

	/**
	 * @Secure(roles="ROLE_PROFESSEUR")
	 */
	public function getNoteForControleAction()
	{
		$reponse = array( 'state' => 0 );

		$controle_id = $this->getRequest()->request->get('controle_id');
		$eleve_id = $this->getRequest()->request->get('eleve_id');

		$note = $this->get('doctrine.orm.entity_manager')->getRepository('KubNoteBundle:Note')->findOneByControleIdAndEleveId( $controle_id, $eleve_id );

		if($note && $note->getControle()->getProfesseur()->getId() == $this->getUser()->getId())
		{
			$reponse = array(

				'state'       => 1,
				'note'        => $note->getNote(),
				'coefficient' => $note->getCoefficient()

			);
		}

		return new Response(
		 	json_encode($reponse)
		);
	}
}
