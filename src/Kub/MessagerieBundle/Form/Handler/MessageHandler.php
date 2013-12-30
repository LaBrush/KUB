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

	public function __construct(Form $form, Request $request, $em)
	{
		$this->form = $form;
		$this->request = $request;
		$this->em = $em;

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
		$thread->setLastMessage($data)

		if($this->form->has('thread_add_member')){

			$participants = $this->form->get('thread_add_member')->getData()->getUsers();
			
			for ($i=0; $i < count($participants) ; $i++) { 
				$thread->addUser( $participants[$i] );
			}

			$groupes = $this->form->get('thread_add_member')->getData()->getGroupes();	

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

			$data->addMessageUser( $mu );
		}
		

		$this->em->persist($data);
		$this->em->flush();
	}
}