<?php

namespace Kub\AbsenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Kub\AbsenceBundle\Form\Type\AppelType ;
use Kub\AbsenceBundle\Form\Handler\AppelHandler; 

use Kub\UserBundle\Entity\Eleve ;
use Kub\AbsenceBundle\Entity\Appel ;
use Kub\AbsenceBundle\Entity\Absence ;

class ProfesseurController extends Controller
{
	/**
	 * @Secure(roles="ROLE_PROFESSEUR")
	 */
	public function appelAction()
	{
		$em = $this->get('doctrine.orm.entity_manager');
		$cours = $em->getRepository('KubEDTBundle:Cours')->getCurrentCoursOf( $this->getUser() );

		if($cours)
		{	
			$semaine = $em->getRepository('KubEDTBundle:Semaine')->findOneBy(array( "numero" => date('W'), "annee" => date('y') ));
			$appel = $em->getRepository('KubAbsenceBundle:Appel')->findOneOrNullByCoursAndSemaine( $cours, $semaine );

			if(!$appel)
			{
				$appel = new Appel ;
				$appel->setHoraire( $cours->getCurrentHoraire() );
				$appel->setSemaine( $semaine );
			}

			foreach ($cours->getEleves() as $eleve) {

				if(!$appel->hasEleve($eleve))
				{
					$absence = new Absence ;
					$absence->setEleve( $eleve );

					$appel->addAbsence( $absence );
				}

			}

			$form  = $this->createForm(new AppelType( $cours->getGroupes() ), $appel, 
				array(
					'action' => $this->generateUrl('kub_absence_professeur_appel')
				)
			);

			$request = $this->get('request');
			if($request->getMethod() == "POST"){

				$formHandler = new AppelHandler($form, $request, $this->get('doctrine.orm.default_entity_manager'), $this->get('kub.notification_manager'));

				if($formHandler->process())
				{
					$this->get('session')->getFlashBag()->add('info', "L'appel a bien été pris en compte");

					return $this->redirect($this->generateUrl("home_homepage"));
				}
				else
				{
					$this->get('session')->getFlashBag()->add('info', "Une erreur est survenue lors de l'appel");   
				}

			}

			return $this->render('KubAbsenceBundle:Professeur:appel.html.twig', array(
				'form' => $form->createView(),
				'eleves' => $cours->getEleves()
			));
		}
		else
		{
			return $this->render('KubAbsenceBundle:Professeur:no_cours.html.twig');
		}
	}

}
