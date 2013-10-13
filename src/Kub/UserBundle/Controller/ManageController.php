<?php

namespace Kub\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Kub\UserBundle\Entity\Eleve ;
use Kub\UserBundle\Entity\Administrateur ;
use Kub\UserBundle\Entity\Tuteur ;
use Kub\UserBundle\Entity\Professeur ;

use Kub\UserBundle\Form\Type\EleveType ;
use Kub\UserBundle\Form\Type\AdministrateurType ;
use Kub\UserBundle\Form\Type\TuteurType ;
use Kub\UserBundle\Form\Type\ProfesseurType ;

use Kub\UserBundle\Form\Handler\EleveHandler ;
use Kub\UserBundle\Form\Handler\AdministrateurHandler ;
use Kub\UserBundle\Form\Handler\TuteurHandler ;
use Kub\UserBundle\Form\Handler\ProfesseurHandler ;

class ManageController extends Controller
{
	/*
	 * @Secure(roles="ROLE_ADMINISTRATEUR")
	 */

	public function createAction($role)
	{
		if($role == "")
		{
			return $this->render('KubUserBundle:Manage:index_create.html.twig');
		}
		else
		{
			$class = ucfirst($role);

			switch($class)
			{
				case "Eleve":
					$type = new EleveType ;
					break;
				case "Tuteur":
					$type = new TuteurType ;
					break;
				case "Professeur":
					$type = new ProfesseurType ;
					break;
				case "Administrateur":
					$type = new AdministrateurType ;
					break;
			}

			$handler = $class . "Handler";

			$userManager = $this->container->get('pugx_user_manager');

			$discriminator = $this->container->get('pugx_user.manager.user_discriminator');
			$discriminator->setClass('Kub\UserBundle\Entity\\'.$class);

			$user = $userManager->createUser();
			$form = $this->createForm($type, $user);

			$request = $this->get('request');

			if($request->getMethod() == "POST"){

				switch($class)
				{
					case "Eleve":
						$formHandler = new EleveHandler($form, $request, $this->getDoctrine()->getManager(), $discriminator, $userManager);
						break;
					case "Tuteur":
						$formHandler = new TuteurHandler($form, $request, $this->getDoctrine()->getManager(), $discriminator, $userManager); ;
						break;
					case "Professeur":
						$formHandler = new ProfesseurHandler($form, $request, $this->getDoctrine()->getManager(), $discriminator, $userManager); ;
						break;
					case "Administrateur":
						$formHandler = new AdministrateurHandler($form, $request, $this->getDoctrine()->getManager(), $discriminator, $userManager); ;
						break;
				}

				if($formHandler->process())
				{
					$this->get('session')->getFlashBag()->add('info', "L'utilisateur a bien été ajouté");
					return $this->redirect($this->generateUrl("Kub_home_homepage"));
				}

			}

			return $this->render('KubUserBundle:Manage:' . $role . '_create.html.twig',
				array(
					'form' => $form->createView()
				)
			);
		}
	}



}
