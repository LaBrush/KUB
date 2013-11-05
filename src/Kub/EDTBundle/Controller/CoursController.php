<?php

namespace Kub\EDTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Kub\EDTBundle\Entity\Cours ;
use Kub\EDTBundle\Form\Type\CoursType ;
use Kub\EDTBundle\Form\Handler\CoursHandler ;

class CoursController extends Controller
{
	/**
	 * @Secure(roles="ROLE_SECRETAIRE")
	 */
	public function createAction()
	{
		$request = $this->get('request');
		$em = $this->getDoctrine()->getManager();
		$time = $this->get('kub.edt.time');

		$type = new CoursType($time) ;
		$cours = new Cours();

		$form = $this->createForm($type, $cours);

		$formHandler = new CoursHandler($form, $request, $em);

		if($request->getMethod() == "POST"){

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', "le cours a bien été ajoutée");
				return $this->redirect($this->generateUrl("cours_list"));
			}
			else
			{
				$this->get('session')->getFlashBag()->add('info', "Erreur lors de l'ajout du cours");
			}

		}

		return $this->render('KubEDTBundle:Cours:create.html.twig',
			array(
				'form' => $form->createView()
			)
		);
	}

	/**
	 * @Secure(roles="ROLE_SECRETAIRE")
	 */
	public function editAction(Cours $cours)
	{
		$request = $this->get('request');
		$em = $this->getDoctrine()->getManager();
		$time = $this->get('kub.edt.time');

		$type = new CoursType($time) ;

		$form = $this->createForm($type, $cours);

		$formHandler = new CoursHandler($form, $request, $em);

		if($request->getMethod() == "POST"){

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', "le cours a bien été modifiée");
				return $this->redirect($this->generateUrl("cours_list"));
			}
			else
			{
				$this->get('session')->getFlashBag()->add('info', "Erreur lors de la modification du cours");
			}

		}

		return $this->render('KubEDTBundle:Cours:edit.html.twig',
			array(
				'form' => $form->createView(),
				'cours' => $cours
			)
		);
	}

	/**
	 * @Secure(roles="ROLE_SECRETAIRE")
	 */
	public function deleteAction(Cours $cours)
	{
		$form = $this->createFormBuilder()->getForm();
		$request = $this->getRequest();

		if ($request->getMethod() == 'POST') {
			$form->bind($request);

			if ($form->isValid()) {

				$em = $this->getDoctrine()->getManager();
				$em->remove($cours);
				$em->flush();

				$this->get('session')->getFlashBag()->add('info', 'Cours bien supprimée');
	
				return $this->redirect($this->generateUrl('cours_list'));
			}
		}

		return $this->render('KubEDTBundle:Cours:delete.html.twig', array(
			'form' => $form->createView(),
			'cours' => $cours
		));
	}

	/**
	 * @Secure(roles="ROLE_USER")
	 */
	public function listAction()
	{
		$listeCours = $this->getDoctrine()->getManager()
			->getRepository("KubEDTBundle:Cours")
			->findAll();

		return $this->render("KubEDTBundle:Cours:list.html.twig", 
			array(
				"list_cours" => $listeCours,
			)
		);
	}
}