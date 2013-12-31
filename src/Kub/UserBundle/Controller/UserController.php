<?php

namespace Kub\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Kub\UserBundle\Entity\User ;
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

use Symfony\Component\Security\Core\Exception\AccessDeniedException; 

class UserController extends Controller
{
	/**
	 * @Secure(roles="ROLE_SECRETAIRE")
	 */
	public function createAction($role)
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
					$type = new AdministrateurType($this->get("security.context")) ;
					break;
			}

			$userManager = $this->container->get('pugx_user_manager');

			$discriminator = $this->container->get('pugx_user.manager.user_discriminator');
			$discriminator->setClass('Kub\UserBundle\Entity\\'.$class);

			$user = $userManager->createUser();
			$form = $this->createForm($type, $user);

			$request = $this->get('request');
			$em = $this->get('doctrine.orm.default_entity_manager');

			if($request->getMethod() == "POST"){

				switch($class)
				{
					case "Eleve":
						$formHandler = new EleveHandler($form, $request, $em, $discriminator, $userManager);
						break;
					case "Tuteur":
						$formHandler = new TuteurHandler($form, $request, $em, $discriminator, $userManager); ;
						break;
					case "Professeur":
						$formHandler = new ProfesseurHandler($form, $request, $em, $discriminator, $userManager); ;
						break;
					case "Administrateur":
						$formHandler = new AdministrateurHandler($form, $request, $em, $discriminator, $userManager); ;
						break;
				}

				if($formHandler->process())
				{
					$this->get('session')->getFlashBag()->add('info', "L'utilisateur a bien été ajouté");
					return $this->redirect($this->generateUrl("user_list", array( "role"=> $role )));
				}

			}

			return $this->render('KubUserBundle:Manage:user_create.html.twig',
				array(
					'form' => $form->createView(),
					'user' => $user
				)
			);
	}

	/**
	 * @Secure(roles="ROLE_SECRETAIRE")
	 */
	public function editAction(User $user, $role, $username)
	{
		if($this->getUser()->getId() == $user->getId())
		{
			throw new AccessDeniedException('Vous ne pouvez modifier votre propre compte');
		}

		if($user->getClass() != $role)
		{
			throw $this->createNotFoundException("L'utilisateur " . $username . " n'a pu être trouvé.");
		}

		$class = ucfirst($role);
		$security = $this->get("security.context");

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
				if( $user->hasRole("ROLE_MANITOU") && !$security->isGranted('ROLE_MANITOU') )
				{
					throw new AccessDeniedException("Vous n'avez pas les droits pour modifier un manitou");
				}

				$type = new AdministrateurType( $security ) ;
				break;
		}

		$form = $this->createForm($type, $user);

		$request = $this->get('request');
		$em = $this->get('doctrine.orm.default_entity_manager');

		$discriminator = $this->container->get('pugx_user.manager.user_discriminator');
		$discriminator->setClass('Kub\UserBundle\Entity\\'.$class);

		$userManager = $this->container->get('pugx_user_manager');

		if($request->getMethod() == "POST"){

			switch($class)
			{
				case "Eleve":
					$formHandler = new EleveHandler($form, $request, $em, $discriminator, $userManager);
					break;
				case "Tuteur":
					$formHandler = new TuteurHandler($form, $request, $em, $discriminator, $userManager); 
					break;
				case "Professeur":
					$formHandler = new ProfesseurHandler($form, $request, $em, $discriminator, $userManager); 
					break;
				case "Administrateur":
					$formHandler = new AdministrateurHandler($form, $request, $em, $discriminator, $userManager);
					break;
			}

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', "L'utilisateur a bien été modifié");
				return $this->redirect($this->generateUrl("user_show",  array("role" => $role, "username" => $user->getUsername())));
			}
			else
			{
				$this->get('session')->getFlashBag()->add('info', "Erreur lors de la modification de l'utilisateur");
			}

		}

		return $this->render('KubUserBundle:Manage:user_edit.html.twig',
			array(
				'form' => $form->createView(),
				'user' => $user,
				'role' => $role
			)
		);
	}

	/**
	 * @Secure(roles="ROLE_SECRETAIRE")
	 */
	public function deleteAction(User $user, $role, $username)
	{
		if($this->getUser()->getId() == $user->getId())
		{
			throw new AccessDeniedException('Vous ne pouvez modifier votre propre compte');
		}

		if($user->getClass() != $role)
		{
			throw $this->createNotFoundException("L'utilisateur " . $username . " n'a pu être trouvé.");
		}

		$form = $this->createFormBuilder()->getForm();
		$request = $this->getRequest();

		if ($request->getMethod() == 'POST') {
			$form->bind($request);

			if ($form->isValid()) {

				$em = $this->get('doctrine.orm.default_entity_manager');
				$em->remove($user);
				$em->flush();

				$this->get('session')->getFlashBag()->add('info', 'Utilisateur bien supprimé');
	
				return $this->redirect($this->generateUrl('user_list'));
			}
		}

		return $this->render('KubUserBundle:Manage:user_delete.html.twig', array(
			'user' => $user,
			'form' => $form->createView(),
			'role' => $role
		));
	}

	/**
	 * @Secure(roles="ROLE_USER")
	 */
	public function listAction($role, $niveau)
	{

		if($role != "eleve" && $niveau != null)
		{
			throw $this->createNotFoundException('Seuls les élèves ont un niveau');
		}

		$manager = $this->get('doctrine.orm.default_entity_manager');
		$repository = $manager->getRepository("KubUserBundle:".ucfirst($role));

		$liste_niveaux = null ;

		if($role == "eleve")
		{
			$liste_niveaux = $manager->getRepository('KubClasseBundle:Niveau')->findAll();
		}

		if($niveau != null)
		{
			$listeUsers = $repository->findByNiveauName($niveau);
		}
		else
		{
			$listeUsers = $repository->findAll();	
		}

		return $this->render("KubUserBundle:Show:list.html.twig", 
			array(
				"list_users" => $listeUsers,
				"role" => $role,
				"liste_niveaux" => $liste_niveaux
		));
	}

	/**
	 * @Secure(roles="ROLE_USER")
	 */
	public function showAction($role, $username)
	{
		$user = $this->get('doctrine.orm.entity_manager')->getRepository('KubUserBundle:' . ucfirst($role))->findOneByUsername($username);

		if($user->getClass() != $role)
		{
			throw $this->createNotFoundException("L'utilisateur " . $username . " n'a pu être trouvé.");
		}

		return $this->render("KubUserBundle:Show:show_" . $role . ".html.twig", 
			array(
				"user" => $user
		));
	}
}
