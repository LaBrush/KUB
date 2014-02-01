<?php

namespace Kub\EDTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Kub\EDTBundle\Entity\Cours ;
use Kub\EDTBundle\Form\Type\CoursType ;
use Kub\EDTBundle\Form\Handler\CoursHandler ;

class CoursController extends Controller
{
	public function showAction($id)
	{
		$cours = $this->get('doctrine.orm.entity_manager')->getRepository('KubEDTBundle:Cours')->findOneById($id);
		$absences = $this->get('doctrine.orm.entity_manager')->getRepository('KubAbsenceBundle:Absence')->findByCoursId($cours->getId());

		$absences_eleves = array();

		for ($i=0; $i < count($absences); $i++) { 
			$eleve = $absences[$i]->getEleve();

			if(!isset($absences_eleves[ (string) $eleve ]))
			{
				$absences_eleves[ (string) $eleve ] = array(
					'eleve' => $eleve,
					'absences' => array()
				);	
			}

			$absences_eleves[ (string) $eleve ]['absences'][] = $absences[$i];
		}

		return $this->render("KubEDTBundle:Cours:show.html.twig", array(
			'cours' => $cours,
			'liste_eleves_absences' => $absences_eleves
		));
	}

	/**
	 * @Secure(roles="ROLE_SECRETAIRE")
	 */
	public function createAction()
	{
		$request = $this->get('request');
		$em = $this->get('doctrine.orm.default_entity_manager');
		$time = $this->get('kub.edt.time');

		$type = new CoursType($time) ;
		$cours = new Cours();

		$form = $this->createForm($type, $cours);

		$formHandler = new CoursHandler($form, $request, $em, $this->get('validator'));

		if($request->getMethod() == "POST"){

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', "Le cours a bien été ajouté");
				return $this->redirect($this->generateUrl("cours_list"));
			}
			else
			{
				$this->get('session')->getFlashBag()->add('info', "Une erreur est survenue lors de l'ajout du cours ");
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
		$em = $this->get('doctrine.orm.default_entity_manager');
		$time = $this->get('kub.edt.time');

		$type = new CoursType($time) ;

		$form = $this->createForm($type, $cours);

		$formHandler = new CoursHandler($form, $request, $em, $this->get('validator'));

		if($request->getMethod() == "POST"){

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', "Le cours a bien été modifié");
				return $this->redirect($this->generateUrl("cours_list"));
			}
			else
			{
				$this->get('session')->getFlashBag()->add('info', "Une erreur est survenue lors de la modification du cours");
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

				$em = $this->get('doctrine.orm.default_entity_manager');
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
	 * @Secure(roles="ROLE_SECRETAIRE")
	 */
	public function listAction()
	{
		$listeCours = $this->get('doctrine.orm.default_entity_manager')
			->getRepository("KubEDTBundle:Cours")
			->findAll();

		return $this->render("KubEDTBundle:Cours:list.html.twig", 
			array(
				"list_cours" => $listeCours,
			)
		);
	}
}
