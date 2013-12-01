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
			throw new \Exception("T'as trouvé un hash pour l'annee et le numéro ? Non ? Qu'est ce que t'attends alors ?", 1);
			
			$semaine = $em->getRepository('KubEDTBundle:Semaine')->findOneBy(array( "numero" ));
			$appel = $em->getRepository('KubEDTBundle:Cours')->findOneOrNullByCoursAndSemaine( $cours, $semaine );

			$appel = new Appel ;
			$appel->setCours( $cours );
			$appel->setSemaine(  );

			$form  = $this->createForm(new AppelType( $this->getUser(), $groupe ), $appel, 
				array(
					'action' => $this->generateUrl('kub_notes_professeur_homepage', array( 'groupe' => $groupe->getName() )
				))
			);

			$request = $this->get('request');
			if($request->getMethod() == "POST"){

				// $formHandler = new AbsenceHandler($form, $request, $this->getDoctrine()->getManager(), $this->get('kub.notification_manager'));

				// if($formHandler->process())
				// {
				// 	$this->get('session')->getFlashBag()->add('info', "L'appel a bien été pris en compte");

				// 	return $this->redirect($this->generateUrl("home_homepage"));
				// }
				// else
				// {
				// 	$this->get('session')->getFlashBag()->add('info', "Une erreur est survenue lors de l'appel");   
				// }

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
