<?php

namespace Kub\MessagerieBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

use Kub\MessagerieBundle\Entity\MessageUser ;

class ThreadHandler
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
		$participants = $this->form->get('users')->getData();
		
		for ($i=0; $i < count($participants) ; $i++) { 
			$data->addUser( $participants[$i] );
		}

		$groupes = $this->form->get('groupes')->getData();	

		for($i=0; $i < count($groupes) ; $i++) {
			$data->addGroupe( $groupes[$i] );	
		}

		/*------------------------------------------*/
		// On donne acces à tous les messages pour les nouveaux arrivants

		$users = $participants->toArray();

        foreach ($groupes as $groupe) {
            $users = array_merge($users, $groupe->getEleves()->toArray());
        }

        $users = array_unique($users, SORT_STRING);

		foreach($users as $user) { 
			foreach ($data->getMessages() as $message) {
				
				$mu = new MessageUser ;
					$mu->setMessage($message);
					$mu->setUser($user);

				if($user == $this->security->getToken()->getUser())
				{
					$mu->setReaded(true);
				}

				$message->addMessageUser( $mu );
			}
		}
		

		$this->em->persist($data);
		$this->em->flush();
	}
}