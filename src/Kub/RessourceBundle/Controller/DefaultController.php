<?php

namespace Kub\RessourceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Kub\RessourceBundle\Entity\Ressource ;
use Kub\RessourceBundle\Form\Type\RessourceType ;
use Kub\RessourceBundle\Form\Handler\RessourceHandler ;

class DefaultController extends Controller
{
	public function indexAction()
	{
		$ressources = $this->get('doctrine.orm.entity_manager')->getRepository('KubRessourceBundle:Ressource')->findAll();

		return $this->render('KubRessourceBundle:Default:index.html.twig', array(
			'ressources' => $ressources
		));
	}

	/**
	 * @Secure(roles={"ROLE_PROFESSEUR"})
	 */
	public function addAction()
	{
		$form = $this->createForm(new RessourceType, null, array(
			'action' => $this->generateUrl('kub_ressource_add')
		));

		$request = $this->get('request');
		$em = $this->getDoctrine()->getManager();

		if($request->getMethod() == "POST"){

			$formHandler = new RessourceHandler($form, $request, $em, $this->get('security.context'), $this->get('kub.notification_manager'));

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', "La ressource à bien été mise en ligne"); 
				$this->redirect( $this->generateUrl('kub_ressource_homepage') );
			}
			else
			{
				$this->get('session')->getFlashBag()->add('info', "Une erreur est survenue lors de l'ajout de la ressource");
			}
		}

		return $this->render('KubRessourceBundle:Ressource:create.html.twig',
			array(
				'form' => $form->createView(),
			)
		);  
  
	}
}
