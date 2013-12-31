<?php

namespace Kub\ArianeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Kub\ArianeBundle\Entity\Commentaire ;
use Kub\ArianeBundle\Entity\Post  ;

use Kub\ArianeBundle\Form\Type\CommentaireType ;
use Kub\ArianeBundle\Form\Handler\CommentaireHandler ;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use JMS\SecurityExtraBundle\Annotation\Secure;

class CommentaireController extends Controller
{

	/**
	 * @Secure(roles={"ROLE_ARIANE"})
	 */
	public function addAction(Post $post)
	{
		$commentaire = new Commentaire ;
		$commentaire->setAuteur($this->getUser());

		$eleve = $post->getFil()->getEleve() ;

		$form = $this->createForm(new CommentaireType, $commentaire, array(
			'action' => $this->generateUrl('ariane_commentaire_add', 
				array(
					'post' => $post->getId()
			))
		));

		$request = $this->get('request');
		$em = $this->get('doctrine.orm.default_entity_manager');

		if($request->getMethod() == "POST"){

			if($this->getUser() != $post->getFil()->getEleve())
			{
				if(!$this->getUser()->hasEleve($post->getFil()->getEleve()))
				{
					throw new AccessDeniedException("Vous n'êtes pas autorisé à commenter ce post");
				}
			}

			$formHandler = new CommentaireHandler($form, $request, $this->get('doctrine.orm.default_entity_manager'), $this->getUser(), $post);

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', "Le commentaire a été posté"); 
				$this->get('kub.notification_manager')->addNotification('ArianeCommentaireNotification', array(

					"userTarget" => $eleve,
					"commentaire" => $commentaire

				)) ;
			}

			$arg = array();
			if($this->getUser()->getClass() == "professeur"){ $arg["username"] = $eleve->getUsername();}
			return $this->redirect($this->generateUrl("ariane_homepage", $arg));
		}

		return $this->render('KubArianeBundle:Commentaire:create.html.twig',
			array(
				'form' => $form->createView(),
				'post' => $post,
			)
		);   
	}

	/**
	 * @Secure(roles={"ROLE_ARIANE"})
	 */
	public function deleteAction(Commentaire $commentaire)
	{
		$form = $this->createFormBuilder(null, array(
			'action' => $this->generateUrl('ariane_commentaire_delete', 
				array(
					'commentaire' => $commentaire->getId()
			))
		))->getForm();

		$request = $this->getRequest();

		if ($request->getMethod() == 'POST') {
			
			if($commentaire->getAuteur() != $this->getUser())
			{
				throw new AccessDeniedException("Vous n'êtes pas autorisé à supprimer ce commentaire");
			}

			$form->bind($request);

			if ($form->isValid()) {

				$em = $this->get('doctrine.orm.default_entity_manager');
				$em->remove($commentaire);
				$em->flush();
		
				$this->get('session')->getFlashBag()->add('info', "Le commentaire a été supprimé");


				return $this->redirect($this->generateUrl("ariane_homepage", $arg));
			}
		}

		return $this->render('KubArianeBundle:Commentaire:delete.html.twig',
			array(
				'form' => $form->createView(),
				'commentaire' => $commentaire
			)
		);
	}
}
