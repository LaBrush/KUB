<?php

namespace Kub\MessagerieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Kub\MessagerieBundle\Form\Type\MessageType ;
use Kub\MessagerieBundle\Form\Handler\MessageHandler ;

use Kub\MessagerieBundle\Entity\Thread ;
use Kub\MessagerieBundle\Entity\Message ;

class DefaultController extends Controller
{
	public function inboxAction(){
		$this->getDoctrine()->getManager()->getRepository('KubMessagerieBundle:MessageUser')->checkUnreadMessage( $this->getUser() );
		$threads = $this->getDoctrine()->getManager()->getRepository('KubMessagerieBundle:Thread')->findByUser( $this->getUser() );

		return $this->render('KubMessagerieBundle:Default:inbox.html.twig', array('threads' => $threads));
	}

	public function readAction($id){
		$thread = $this->getDoctrine()->getManager()->getRepository('KubMessagerieBundle:Thread')->findOneByIdAndCheck( $id );

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
		$em = $this->getDoctrine()->getManager();

		if($request->getMethod() == "POST"){

			$formHandler = new MessageHandler($form, $request, $this->getDoctrine()->getManager());

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

		$thread = $this->getDoctrine()->getManager()->getRepository('KubMessagerieBundle:Thread')->findOneById( $id );		

		$message = new Message ;
		$message->setThread($thread);
		$message->setSender( $this->getUser() );

		$form = $this->createForm(new MessageType, $message, array(
			"action" => $this->generateUrl("kub_messagerie_send", array('id' => $id))
		));

		$request = $this->get('request');
		$em = $this->getDoctrine()->getManager();

		if($request->getMethod() == "POST"){

			$formHandler = new MessageHandler($form, $request, $this->getDoctrine()->getManager());

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

		$form = $this->createFormBuilder()->getForm();
		$request = $this->getRequest();

		if ($request->getMethod() == 'POST') {
			$form->bind($request);

			if ($form->isValid()) {

				$em = $this->getDoctrine()->getManager();

				$links = $em->getRepository('KubMessagerieBundle:MessageUser')->findByUserAndThreadId($this->getUser(), $id);

				for ($i=0; $i < count($links); $i++) { 
					$em->remove($links[$i]);
				}
				$em->flush();

				$this->get('session')->getFlashBag()->add('info', 'La conversation a bien été supprimée');
	
				return $this->redirect($this->generateUrl('kub_messagerie_inbox'));
			}
		}

		return $this->render('KubMessagerieBundle:Conversation:delete.html.twig', array(
			'form' => $form->createView(),
		));
	}
}