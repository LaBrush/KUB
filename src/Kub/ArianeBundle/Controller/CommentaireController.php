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
		if($this->getUser() != $post->getFil()->getEleve())
		{
			if($this->getUser()->hasEleve($post->getFil()->getEleve()))
			{
				throw new AccessDeniedException("Vous n'êtes pas autorisé à commenter ce post");
			}
		}

		$commentaire = new Commentaire ;
		$commentaire->setAuteur($this->getUser());

		$form = $this->createForm(new CommentaireType, $commentaire, array(
			'action' => $this->generateUrl('ariane_commentaire_add', 
				array(
					'post' => $post->getId()
			))
		));

		$request = $this->get('request');
		$em = $this->getDoctrine()->getManager();

		if($request->getMethod() == "POST"){

			$formHandler = new CommentaireHandler($form, $request, $this->getDoctrine()->getManager(), $this->getUser(), $post);

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', "Le commentaire a été posté");   
			}

			return $this->redirect($this->generateUrl("ariane_homepage"));

		}

		return $this->render('KubArianeBundle:Commentaire:create.html.twig',
			array(
				'form' => $form->createView()
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

				$em = $this->getDoctrine()->getManager();
				$em->remove($commentaire);
				$em->flush();
		
				$this->get('session')->getFlashBag()->add('info', "Le commentaire a été supprimé");

				return $this->redirect($this->generateUrl("ariane_homepage"));
			}
		}

		return $this->render('KubArianeBundle:Commentaire:delete.html.twig',
			array(
				'form' => $form->createView(),
			)
		);
	}
}
