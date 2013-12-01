<?php

namespace Kub\NoteBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class ControleHandler
{
	protected $request;
	protected $form;
	protected $em;
	protected $notifications;

	/**
	 * Initialize the handler with the form and the request
	 *
	 * @param Form $form
	 * @param Request $request
	 * @param $em
	 * 
	 */
	public function __construct(Form $form, Request $request, $em, $notifications)
	{
		$this->form = $form;
		$this->request = $request;
		$this->em = $em;
		$this->notifications = $notifications ;
	}

	public function process()
	{
		if('POST' == $this->request->getMethod())
		{
			$this->form->bind($this->request);

			if($this->form->isValid())
			{
				return $this->onSuccess();
			}
		}

		return false;
	}

	private function onSuccess()
	{
		$notes = $this->form['notes']->getData();
		$controle = $this->form->getData();

		foreach ($notes as $note) {

			if(!$note->getNoter())
			{
				$controle->removeNote( $note ) ;
			}
			else
			{
				$this->notifications->addNotification('NoteAddedNotification', array(

					"userTarget" => $note->getEleve(),
					"contenu" => $note

				)) ;
			}
	
		}

		if( count($controle->getNotes()) > 0)
		{
			$this->em->persist($controle);
			$this->em->flush();
		}

		return true ;
	}
}