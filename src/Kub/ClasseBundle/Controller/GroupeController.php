<?php

namespace Kub\ClasseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Kub\ClasseBundle\Entity\Groupe;
use Kub\ClasseBundle\Form\Type\GroupeType ;
use Kub\ClasseBundle\Form\Handler\GroupeHandler ;

/**
 * Groupe controller.
 */
class GroupeController extends Controller
{
	/**
	 * @Secure(roles="ROLE_SECRETAIRE")
	 */
	public function createAction()
	{
		$groupe = new Groupe ;
		$form = $this->createForm(new GroupeType, $groupe);

		$request = $this->get('request');
		$em = $this->get('doctrine.orm.default_entity_manager');

		if($request->getMethod() == "POST"){

			$formHandler = new GroupeHandler($form, $request, $this->get('doctrine.orm.default_entity_manager'));

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', "Le groupe a bien été ajouté");
				return $this->redirect($this->generateUrl("groupe_list"));
			}

		}

		return $this->render('KubClasseBundle:Groupe:create.html.twig',
			array(
				'form' => $form->createView(),
				'groupe' => $groupe
			)
		);
	}

	/**
	 * @Secure(roles="ROLE_SECRETAIRE")
	 */
	public function editAction(Groupe $groupe)
	{
		$form = $this->createForm(new GroupeType, $groupe);

		$request = $this->get('request');
		$em = $this->get('doctrine.orm.default_entity_manager');

		if($request->getMethod() == "POST"){

			$formHandler = new GroupeHandler($form, $request, $this->get('doctrine.orm.default_entity_manager'));

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', "Le groupe a bien été modifié");
				return $this->redirect($this->generateUrl("groupe_list"));
			}

		}

		return $this->render('KubClasseBundle:Groupe:edit.html.twig',
			array(
				'form' => $form->createView(),
				'groupe' => $groupe
			)
		);
	}

	/**
	 * @Secure(roles="ROLE_SECRETAIRE")
	 */
	public function deleteAction(Groupe $groupe)
	{
		$form = $this->createFormBuilder()->getForm();
		$request = $this->getRequest();

		if ($request->getMethod() == 'POST') {
			$form->bind($request);

			if ($form->isValid()) {

				$em = $this->get('doctrine.orm.default_entity_manager');
				$em->remove($groupe);
				$em->flush();

				$this->get('session')->getFlashBag()->add('info', 'Groupe bien supprimé');
	
				return $this->redirect($this->generateUrl('groupe_list'));
			}
		}

		return $this->render('KubClasseBundle:Groupe:delete.html.twig', array(
			'groupe' => $groupe,
			'form' => $form->createView(),
		));
	}

	public function listAction()
	{
		$listeGroupes = $this->get('doctrine.orm.default_entity_manager')
			->getRepository("KubClasseBundle:Groupe")
			->findAll();

		return $this->render("KubClasseBundle:Groupe:list.html.twig", 
			array(
				"list_groupes" => $listeGroupes
		));        
	}

	public function listForUserAction()
	{
		$listeGroupes = $this->get('doctrine.orm.default_entity_manager')
			->getRepository("KubClasseBundle:Groupe")
			->findByUser($this->getUser());

		return $this->render("KubClasseBundle:Groupe:list.html.twig", 
			array(
				"list_groupes" => $listeGroupes
		));        
	}

	public function showAction(Groupe $groupe)
	{
		return $this->render("KubClasseBundle:Groupe:show.html.twig", 
			array(
				"groupe" => $groupe
			)
		);

	}

}
