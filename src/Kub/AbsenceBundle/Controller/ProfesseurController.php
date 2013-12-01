<?php

namespace Kub\AbsenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Kub\AbsenceBundle\Form\Type\ControleType ;
use Kub\AbsenceBundle\Form\Handler\ControleHandler; 

use Kub\UserBundle\Entity\Eleve ;
use Kub\AbsenceBundle\Entity\Note ;
use Kub\AbsenceBundle\Entity\Controle ;

class ProfesseurController extends Controller
{
	/**
	 * @Secure(roles="ROLE_PROFESSEUR")
	 */
	public function appelAction()
	{
		$cours = $this->get('doctrine.orm.entity_manager')->getRepository('KubEDTBundle:Cours')->getCurrentCoursOf( $this->getUser() );

		if($cours)
		{

			$absence = new Controle ;
			$absence->setGroupe($groupe);
			$absence->setProfesseur( $this->getUser() );

			$form  = $this->createForm(new ControleType( $this->getUser(), $groupe ), $absence, 
				array(
					'action' => $this->generateUrl('kub_notes_professeur_homepage', array( 'groupe' => $groupe->getName() )
				))
			);

			$request = $this->get('request');
			if($request->getMethod() == "POST"){

				$formHandler = new ControleHandler($form, $request, $this->getDoctrine()->getManager(), $this->get('kub.notification_manager'));

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

			return $this->render('KubAbsenceBundle:Professeur:appel.html.twig', array(
				'form' => $form->createView()
			));
		}
		else
		{
			return $this->render('KubAbsenceBundle:Professeur:no_cours.html.twig');
		}
	}

}
