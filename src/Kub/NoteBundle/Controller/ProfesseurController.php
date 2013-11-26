<?php

namespace Kub\NoteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Kub\NoteBundle\Form\Type\NoteGroupeType ;
use Kub\NoteBundle\Form\Handler\NoteGroupeHandler; 

use Kub\UserBundle\Entity\Eleve ;
use Kub\NoteBundle\Entity\Note ;

class ProfesseurController extends Controller
{
	/**
	 * @Secure(roles="ROLE_PROFESSEUR")
	 */
	public function addAction($groupe)
	{
		if (null == $groupe) {
			$liste_groupes = $this->get('doctrine.orm.entity_manager')->getRepository('KubClasseBundle:Groupe')->getGroupesOfProfesseur( $this->getUser() );

			return $this->render('KubNoteBundle:Professeur:index.html.twig', array(
				'groupes' => $liste_groupes
			));
		}
		else
		{
			$groupe = $this->get('doctrine.orm.entity_manager')->getRepository('KubClasseBundle:Groupe')->findOneByName( $groupe );
			$form  = $this->createForm(new NoteGroupeType( $groupe, $this->getUser() ), null, array( 
				'action' => $this->generateUrl('kub_notes_professeur_homepage', array( 'groupe' => $groupe->getName() )
			)));

			$request = $this->get('request');
			if($request->getMethod() == "POST"){

				$formHandler = new NoteGroupeHandler($form, $request, $this->getDoctrine()->getManager(), $this->get('kub.notification_manager'));

				if($formHandler->process())
				{
					$this->get('session')->getFlashBag()->add('info', "Les notes ont bien été ajoutées");

					return $this->redirect($this->generateUrl("home_homepage"));
				}
				else
				{
					$this->get('session')->getFlashBag()->add('info', "Une erreur est survenue lors de l'ajout des notes");   
				}

			}

			return $this->render('KubNoteBundle:Professeur:noter.html.twig', array(
				'form' => $form->createView()
			));
		}
	}

	/**
	 * @Secure(roles="ROLE_PROFESSEUR")
	 */
	public function deleteAction(Note $note)
	{
		$form = $this->createFormBuilder(null, array(
			'action' => $this->generateUrl('kub_notes_professeur_delete', 
				array(
					'note' => $note->getId()
			))
		))->getForm();

		$request = $this->getRequest();

		if ($request->getMethod() == 'POST') {
			
			if($note->getProfesseur() != $this->getUser())
			{
				throw new AccessDeniedException("Vous n'êtes pas autorisé à supprimer cette note");
			}

			$form->bind($request);

			if ($form->isValid()) {

				$em = $this->getDoctrine()->getManager();
				$em->remove($note);
				$em->flush();
		
				$this->get('session')->getFlashBag()->add('info', "La note a été supprimée");

				return $this->redirect($this->generateUrl('user_show', array('role'=> $note->getEleve()->getClass(), 'username'=> $note->getEleve()->getUsername()) ));
			}
		}

		return $this->render('KubNoteBundle:Professeur:delete.html.twig',
			array(
				'form' => $form->createView(),
				'note' => $note
			)
		);
	}

	public function showEleveAction(Eleve $eleve)
	{
		$liste_notes = $this->get('doctrine.orm.entity_manager')->getRepository('KubNoteBundle:Note')->findByEleve( $eleve );

		$template = 'show';
		if($this->get('request')->attributes->get('_route') != 'kub_notes_eleve_show') { $template .= "_content" ; }

		return $this->render('KubNoteBundle:Show:' . $template . '.html.twig',
			array(
				'notes' => $liste_notes,
				'eleve' => $eleve
			)
		);   

	}
}
