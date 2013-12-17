<?php

namespace Kub\NoteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Kub\NoteBundle\Form\Type\ControleType ;
use Kub\NoteBundle\Form\Handler\ControleHandler; 

use Kub\UserBundle\Entity\Eleve ;
use Kub\NoteBundle\Entity\Note ;
use Kub\NoteBundle\Entity\Controle ;

class ProfesseurController extends Controller
{
	/**
	 * @Secure(roles="ROLE_PROFESSEUR")
	 */
	public function addAction($cours)
	{
		if (null == $cours) {
			$liste_cours = $this->get('doctrine.orm.entity_manager')->getRepository('KubEDTBundle:Cours')->findByProfesseur( $this->getUser() );

			return $this->render('KubNoteBundle:Professeur:index.html.twig', array(
				'liste_cours' => $liste_cours
			));
		}
		else
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

				$formHandler = new ControleHandler($form, $request, $this->getDoctrine()->getManager(), $this->get('kub.notification_manager'));

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
