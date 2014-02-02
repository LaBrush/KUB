<?php

namespace Kub\MessagerieBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

use Kub\MessagerieBundle\Entity\MessageUser ;

class MessageHandler 
{
	protected $request;
	protected $form;
	protected $em;
	protected $security;

	public function __construct(Form $form, Request $request, $em, $security)
	{
		$this->form = $form;
		$this->request = $request;
		$this->em = $em;
		$this->security = $security ;

	}

	public function process()
	{
		if('POST' == $this->request->getMethod())
		{
			$this->form->bind($this->request);

			if($this->form->isValid())
			{
				$data = $this->form->getData();
				$this->onSuccess($data);

				return true;
			}
		}
		
		return false;
	}

	protected function onSuccess($data)
	{
		$thread = $data->getThread();

		if($this->form->has('thread_add_member')){

			$participants = $this->form->get('thread_add_member')->get('users')->getData();

			for ($i=0; $i < count($participants) ; $i++) { 
				$thread->addUser( $participants[$i] );
			}

			$groupes = $this->form->get('thread_add_member')->get('groupes')->getData();	

			for($i=0; $i < count($groupes) ; $i++) {
				$thread->addGroupe( $groupes[$i] );	
			}
		}
		$thread->addUser( $data->getSender() );

		$this->em->persist($data);
		$this->em->flush();

		foreach($thread->getAllUsers() as $user) { 
			$mu = new MessageUser ;
				$mu->setMessage($data);
				$mu->setUser($user);

			if($user == $this->security->getToken()->getUser())
			{
				$mu->setReaded(true);
			}

			$data->addMessageUser( $mu );
		}
		

		$this->em->persist($data);
		$this->em->flush();
	}
}