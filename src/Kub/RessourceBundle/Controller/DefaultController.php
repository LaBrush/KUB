<?php

namespace Kub\RessourceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\Exception\AccessDeniedException ;

use Kub\RessourceBundle\Entity\Ressource ;
use Kub\RessourceBundle\Form\Type\RessourceType ;
use Kub\RessourceBundle\Form\Handler\RessourceHandler ;

class DefaultController extends Controller
{
	public function indexAction()
	{
		$ressources = $this->get('doctrine.orm.entity_manager')->getRepository('KubRessourceBundle:Ressource')->findByValide();
		$matieres = array();

		for ($i=0; $i < count($ressources) ; $i++) { 
			if(!in_array($ressources[$i]->getMatiere(), $matieres))
			{
				$matieres[] = $ressources[$i]->getMatiere();
			}
		}

		return $this->render('KubRessourceBundle:Default:index.html.twig', array(
			'ressources' => $ressources,
			'matieres' => $matieres
		));
	}

	public function showAction($id){
		$ressource = $this->get('doctrine.orm.entity_manager')->getRepository('KubRessourceBundle:Ressource')->findOneById($id);

		return $this->render('KubRessourceBundle:Ressource:show.html.twig', array(
			'ressource' => $ressource
		));		
	}

	public function addAction()
	{
		$ressource = new Ressource();

		if(!$this->get('security.context')->isGranted('ROLE_PROFESSEUR'))
		{
			$ressource->setValide(false);
		}

		$form = $this->createForm(new RessourceType, $ressource, array(
			'action' => $this->generateUrl('kub_ressource_add')
		));

		$request = $this->get('request');
		$em = $this->getDoctrine()->getManager();

		if($request->getMethod() == "POST"){

			$formHandler = new RessourceHandler($form, $request, $em, $this->get('security.context'), $this->get('kub.notification_manager'));

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', "La ressource à bien été mise en ligne"); 
				return $this->redirect( $this->generateUrl('kub_ressource_homepage') );
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

	public function editAction(Ressource $ressource)
	{
		if($this->getUser() != $ressource->getDepositaire())
		{
			throw new AccessDeniedException('Vous ne pouvez modifier cette ressource');
			
		}

		if(!$this->get('security.context')->isGranted('ROLE_PROFESSEUR'))
		{
			$ressource->setValide(false);
		}

		$form = $this->createForm(new RessourceType, $ressource, array(
			'action' => $this->generateUrl('kub_ressource_add')
		));

		$request = $this->get('request');
		$em = $this->getDoctrine()->getManager();

		if($request->getMethod() == "POST"){

			$formHandler = new RessourceHandler($form, $request, $em, $this->get('security.context'), $this->get('kub.notification_manager'));

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', "La ressource à bien été modifiée"); 
				return $this->redirect( $this->generateUrl('kub_ressource_homepage') );
			}
			else
			{
				$this->get('session')->getFlashBag()->add('info', "Une erreur est survenue lors de la modification de la ressource");
			}
		}

		return $this->render('KubRessourceBundle:Ressource:create.html.twig',
			array(
				'form' => $form->createView(),
			)
		); 
	}
}
