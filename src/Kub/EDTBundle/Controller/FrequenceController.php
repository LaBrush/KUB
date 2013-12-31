<?php

namespace Kub\EDTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Kub\EDTBundle\Entity\Frequence ;
use Kub\EDTBundle\Form\Type\FrequenceType ;
use Kub\EDTBundle\Form\Handler\FrequenceHandler ;

class FrequenceController extends Controller
{
	/**
	 * @Secure(roles="ROLE_SECRETAIRE")
	 */
	public function createAction()
	{
		$type = new FrequenceType() ;
		$frequence = new Frequence();

		$form = $this->createForm($type, $frequence);

		$request = $this->get('request');
		$em = $this->get('doctrine.orm.default_entity_manager');

		$formHandler = new FrequenceHandler($form, $request, $em);

		if($request->getMethod() == "POST"){

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', "la fréquence a bien été ajoutée");
				return $this->redirect($this->generateUrl("frequence_list"));
			}
			else
			{
				$this->get('session')->getFlashBag()->add('info', "Erreur lors de l'ajout de la fréquence");
			}

		}

		return $this->render('KubEDTBundle:Frequence:create.html.twig',
			array(
				'form' => $form->createView()
			)
		);
	}

	/**
	 * @Secure(roles="ROLE_SECRETAIRE")
	 */
	public function editAction(Frequence $frequence)
	{
		$type = new FrequenceType() ;
		$form = $this->createForm($type, $frequence);

		$request = $this->get('request');
		$em = $this->get('doctrine.orm.default_entity_manager');

		$formHandler = new FrequenceHandler($form, $request, $em);

		if($request->getMethod() == "POST"){

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', "la fréquence a bien été modifiée");
				return $this->redirect($this->generateUrl("frequence_list"));
			}
			else
			{
				$this->get('session')->getFlashBag()->add('info', "Erreur lors de la modification de la fréquence");
			}

		}

		return $this->render('KubEDTBundle:Frequence:edit.html.twig',
			array(
				'form' => $form->createView(),
				'frequence' => $frequence
			)
		);
	}

	/**
	 * @Secure(roles="ROLE_SECRETAIRE")
	 */
	public function deleteAction(Frequence $frequence)
	{
		$form = $this->createFormBuilder()->getForm();
		$request = $this->getRequest();

		if ($request->getMethod() == 'POST') {
			$form->bind($request);

			if ($form->isValid()) {

				$em = $this->get('doctrine.orm.default_entity_manager');
				$em->remove($frequence);
				$em->flush();

				$this->get('session')->getFlashBag()->add('info', 'Frequence bien supprimée');
	
				return $this->redirect($this->generateUrl('frequence_list'));
			}
		}

		return $this->render('KubEDTBundle:Frequence:delete.html.twig', array(
			'form' => $form->createView(),
			'frequence' => $frequence
		));
	}

	/**
	 * @Secure(roles="ROLE_USER")
	 */

	public function listAction()
	{
		$listeFrequences = $this->get('doctrine.orm.default_entity_manager')
			->getRepository("KubEDTBundle:Frequence")
			->findAll();

		return $this->render("KubEDTBundle:Frequence:list.html.twig", 
			array(
				"list_frequence" => $listeFrequences,
			)
		);
	}
}
