<?php

namespace Kub\NoteBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class NoteSingleHandler
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
		$this->notifications = $notifications;
	}

	public function process()
	{
		if('POST' == $this->request->getMethod())
		{
			if($this->form["noter"]->getData() == false)
			{
				return true ;
			}

			if($this->form->isValid())
			{
				$data = $this->form->getData();
				$this->onSuccess($data);
				return true ;
			}
		}

		return false;
	}

	protected function onSuccess($data)
	{
		$this->notifications->addNotification('NoteAddedNotification', array(

			"userTarget" => $data->getEleve(),
			"note" => $data

		)) ;

		$this->em->persist($data);
		$this->em->flush();

		return true;
	}
}