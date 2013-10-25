<?php

namespace Kub\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Kub\UserBundle\Entity\Groupe;
use Kub\UserBundle\Form\Type\GroupeType ;
use Kub\UserBundle\Form\Handler\GroupeHandler ;

/**
 * Groupe controller.
 *
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
		$em = $this->getDoctrine()->getManager();

		if($request->getMethod() == "POST"){

			$formHandler = new GroupeHandler($form, $request, $this->getDoctrine()->getManager());

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', "Le groupe a bien été ajouté");
				return $this->redirect($this->generateUrl("home_homepage"));
			}

		}

		return $this->render('KubUserBundle:Groupe:create.html.twig',
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
		$em = $this->getDoctrine()->getManager();

		if($request->getMethod() == "POST"){

			$formHandler = new GroupeHandler($form, $request, $this->getDoctrine()->getManager());

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', "Le groupe a bien été modifié");
				return $this->redirect($this->generateUrl("home_homepage"));
			}

		}

		return $this->render('KubUserBundle:Groupe:create.html.twig',
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

				$em = $this->getDoctrine()->getManager();
				$em->remove($groupe);
				$em->flush();

				$this->get('session')->getFlashBag()->add('info', 'Groupe bien supprimé');
	
				return $this->redirect($this->generateUrl('groupe_list'));
			}
		}

		return $this->render('KubUserBundle:Groupe:delete.html.twig', array(
			'groupe' => $groupe,
			'form' => $form->createView(),
		));
	}

	/**
	 * @Secure(roles="ROLE_USER")
	 */

	public function listAction()
	{
		$listeGroupes = $this->getDoctrine()->getManager()
			->getRepository("KubUserBundle:Groupe")
			->findAll();

		return $this->render("KubUserBundle:Groupe:list.html.twig", 
			array(
				"list_users" => $listeGroupes
		));        
	}

	/**
	 * @Secure(roles="ROLE_USER")
	 */

	public function showAction(Groupe $groupe)
	{

		return $this->render("KubUserBundle:Groupe:show.html.twig", 
			array(
				"groupe" => $groupe
			)
		);

	}

}
