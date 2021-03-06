<?php

namespace Kub\ArianeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Kub\ArianeBundle\Entity\Post ;
use Kub\ArianeBundle\Entity\Fil  ;

use Kub\ArianeBundle\Form\Type\PostType ;
use Kub\ArianeBundle\Form\Handler\PostHandler ;

class PostController extends Controller
{
	/**
	 * @Secure(roles="ROLE_ELEVE")
	 */
	public function addAction()
	{
		$post = new Post ;
		$form = $this->createForm(new PostType, $post, array(
			"method" => "POST",
			"action" => $this->generateUrl('ariane_post_add')
		));

		$request = $this->get('request');
		$em = $this->get('doctrine.orm.default_entity_manager');

		$fil = $this->getUser()->getFil();

		if($request->getMethod() == "POST"){

			$formHandler = new PostHandler($form, $request, $this->get('doctrine.orm.default_entity_manager'), $fil, $this->get('kub.notification_manager'), $this->get('security.context'));

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', "Le post a bien été ajouté");

				return $this->redirect($this->generateUrl("ariane_homepage"));
			}

		}

		$template = 'create';

		if($this->get('request')->attributes->get('_route') != 'ariane_post_add')
		{
			$template .= "_content" ; 
		}

		return $this->render('KubArianeBundle:Post:' . $template . '.html.twig',
			array(
				'form' => $form->createView(),
			)
		);   
	}

	/**
	 * @Secure(roles="ROLE_ELEVE")
	 */
	public function editAction(Post $post)
	{
		$form = $this->createForm(new PostType, $post);

		$request = $this->get('request');
		$em = $this->get('doctrine.orm.default_entity_manager');

		$fil = $this->getUser()->getFil();

		if($request->getMethod() == "POST"){

			$formHandler = new PostHandler($form, $request, $this->get('doctrine.orm.default_entity_manager'), $fil, $this->get('kub.notification_manager'), $this->get('security.context'));

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', "Le post a bien été modifié");
				return $this->redirect($this->generateUrl("ariane_homepage"));
			}

		}

		return $this->render('KubArianeBundle:Post:edit.html.twig',
			array(
				'form' => $form->createView(),
				'post' => $post,
			)
		);   
	}

	/**
	 * @Secure(roles="ROLE_ELEVE")
	 */
	public function deleteAction(Post $post)
	{
		$form = $this->createFormBuilder()->getForm();
		$request = $this->getRequest();

		if ($request->getMethod() == 'POST') {
			$form->bind($request);

			if ($form->isValid()) {

				$em = $this->get('doctrine.orm.default_entity_manager');
				$em->remove($post);
				$em->flush();

				$this->get('session')->getFlashBag()->add('info', 'Trace bien supprimée');
	
				return $this->redirect($this->generateUrl('ariane_homepage'));
			}
		}

		return $this->render('KubArianeBundle:Post:delete.html.twig', array(
			'form' => $form->createView(),
			'post' => $post,
		));
	}
}
