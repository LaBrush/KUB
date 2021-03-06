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
		$ressources = $this->get('doctrine.orm.entity_manager')->getRepository('KubRessourceBundle:Ressource')->findByValide(true);
		$ressources_invalides = $this->get('doctrine.orm.entity_manager')->getRepository('KubRessourceBundle:Ressource')->findByValideAndUser(false, $this->getUser());

		$matieres = array();
		$auteurs = array();
		$depositaires = array();

		for ($i=0; $i < count($ressources) ; $i++) { 
			if(!in_array($ressources[$i]->getMatiere(), $matieres))
			{
				$matieres[] = $ressources[$i]->getMatiere();
			}

			if(!in_array($ressources[$i]->getAuteur(), $auteurs))
			{
				$auteurs[] = $ressources[$i]->getAuteur();
			}

			if(!in_array($ressources[$i]->getDepositaire(), $depositaires))
			{
				$depositaires[] = $ressources[$i]->getDepositaire();
			}
		}

		return $this->render('KubRessourceBundle:Default:index.html.twig', array(
			'ressources' => $ressources,
			'ressources_invalides' => $ressources_invalides,
			'matieres' => $matieres,
			'auteurs' => $auteurs,
			'depositaires' => $depositaires
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
		$em = $this->get('doctrine.orm.default_entity_manager');

		if($request->getMethod() == "POST"){

			$formHandler = new RessourceHandler($form, $request, $em, $this->get('security.context'), $this->get('validator'), $this->get('kub.notification_manager'));

			if($formHandler->process())
			{
				if($this->get('security.context')->isGranted('ROLE_PROFESSEUR'))
				{
					$this->get('session')->getFlashBag()->add('info', "La ressource a bien été mise en ligne"); 
				}
				else
				{
					$this->get('session')->getFlashBag()->add('info', "La ressource a bien été mise en ligne. Elle devra être validée par un professeur avant d'être publiée.");
				}
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
		$em = $this->get('doctrine.orm.default_entity_manager');

		if($request->getMethod() == "POST"){

			$formHandler = new RessourceHandler($form, $request, $em, $this->get('security.context'), $this->get('validator'), $this->get('kub.notification_manager'));

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', "La ressource a bien été modifiée."); 
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

	public function deleteAction(Ressource $ressource)
	{
		$form = $this->createFormBuilder()->getForm();
		$request = $this->getRequest();

		if ($request->getMethod() == 'POST') {
			$form->bind($request);

			if ($form->isValid()) {

				$em = $this->get('doctrine.orm.default_entity_manager');
				$em->remove($ressource);
				$em->flush();

				$this->get('session')->getFlashBag()->add('info', 'Ressource supprimée');
	
				return $this->redirect($this->generateUrl('kub_ressource_homepage'));
			}
		}

		return $this->render('KubRessourceBundle:Ressource:delete.html.twig', array(
			'ressource' => $ressource,
			'form' => $form->createView(),
		));
	}
}
