<?php

namespace Kub\MessagerieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\HttpKernelInterface ;

use Kub\MessagerieBundle\Form\Type\MessageType ;
use Kub\MessagerieBundle\Form\Handler\MessageHandler ;

use Kub\MessagerieBundle\Entity\Thread ;
use Kub\MessagerieBundle\Entity\Message ;

class DefaultController extends Controller
{
	public function inboxAction(){
		$threads = $this->get('doctrine.orm.default_entity_manager')->getRepository('KubMessagerieBundle:Thread')->findByUser( $this->getUser() );

		return $this->render('KubMessagerieBundle:Default:inbox.html.twig', array('threads' => $threads));
	}

	public function readAction($id){
		$em = $this->get('doctrine.orm.default_entity_manager');
		$thread = $em->getRepository('KubMessagerieBundle:Thread')->findOneById( $id );

		//On marque les messages en cours de consultation comme lus
		$connection = $em->getConnection();
		$statement = $connection->update(
			"
				MessageUser mu
				JOIN Message m
				ON mu.message_id = m.id
			",
			array("mu.readed" => 1),
			array(
				"mu.readed" => 0,
				"mu.user_id" => $this->getUser()->getId(),
				"m.thread_id" => $thread->getId()
			)
		);

		if(!in_array($this->getUser(), $thread->getAllUsers()))
		{
			throw new AccessDeniedException("Vous ne participez actuellement pas à cette conversation");
		}

		return $this->render('KubMessagerieBundle:Conversation:show.html.twig', array('thread' => $thread));
	}

	public function newAction(){

		$thread = new Thread ; 

		$message = new Message ;
		$message->setThread($thread);
		$message->setSender( $this->getUser() );

		$form = $this->createForm(new MessageType, $message);

		$request = $this->get('request');
		$em = $this->get('doctrine.orm.default_entity_manager');

		if($request->getMethod() == "POST"){

			$formHandler = new MessageHandler($form, $request, $this->get('doctrine.orm.default_entity_manager'), $this->get('security.context'));

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', "Le message a bien été envoyé");

				return $this->redirect($this->generateUrl("kub_messagerie_inbox"));
			}

		}
		return $this->render('KubMessagerieBundle:Conversation:new.html.twig',
			array(
				'form' => $form->createView()
			)
		);   
	}

	public function sendAction($id){

		$thread = $this->get('doctrine.orm.default_entity_manager')->getRepository('KubMessagerieBundle:Thread')->findOneById( $id );		

		$message = new Message ;
		$message->setThread($thread);
		$message->setSender( $this->getUser() );

		$form = $this->createForm(new MessageType, $message, array(
			"action" => $this->generateUrl("kub_messagerie_send", array('id' => $id))
		));

		$request = $this->get('request');
		$em = $this->get('doctrine.orm.default_entity_manager');

		if($request->getMethod() == "POST"){

			$formHandler = new MessageHandler($form, $request, $this->get('doctrine.orm.default_entity_manager'), $this->get('security'));

			if($formHandler->process())
			{
				$this->get('session')->getFlashBag()->add('info', "Le message a bien été envoyé");
			}

		}

		if($this->get('request')->get('_route') == "kub_messagerie_send")
		{
			return $this->redirect($this->generateUrl("kub_messagerie_read", array('id' => $id)));
		}	
		else
		{
			return $this->render('KubMessagerieBundle:Message:send_content.html.twig',
				array(
					'form' => $form->createView()
				)
			);
		}
	}

	public function deleteAction($id){

		$form = $this->createFormBuilder(null, array(
			"action" => $this->generateUrl("kub_messagerie_delete", array("id" => $id)),
			"method" => "POST"
		))->getForm();

		$request = $this->getRequest();

		if ($request->getMethod() == 'POST') {
			$form->bind($request);

			if ($form->isValid()) {

				$em = $this->get('doctrine.orm.default_entity_manager');

				$links = $em->getRepository('KubMessagerieBundle:MessageUser')->findByUserAndThreadId($this->getUser(), $id);

				for ($i=0; $i < count($links); $i++) { 
					$em->remove($links[$i]);
				}
				$em->flush();

				$this->get('session')->getFlashBag()->add('info', 'La conversation a bien été supprimée');
			}

			return $this->redirect($this->generateUrl('kub_messagerie_inbox'));
		}
		
		return $this->render('KubMessagerieBundle:Conversation:delete_content.html.twig', array(
			'form' => $form->createView(),
		));
	}
}
