<?php

namespace Kub\RessourceBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class RessourceHandler
{
	protected $request;
	protected $form;
	protected $em;
	protected $notification ;
	protected $security ;

	public function __construct(Form $form, Request $request, $em, $security, $notification)
	{
		$this->form = $form;
		$this->request = $request;
		$this->em = $em;
		$this->notification = $notification ;
		$this->security = $security ;

	}

	public function process()
	{	
		if('POST' == $this->request->getMethod())
		{
			$this->form->bind($this->request);

			if($this->form->isValid())
			{
				$this->onSuccess( $this->form->getData() );

				return true;
			}
		}

		return false;
	}

	protected function onSuccess($data)
	{
		$this->em->persist($data);
		$this->em->flush();

		// $this->notification->addNotification('ArianePostNotification', array(

		// 	'userTarget' => $this->security->getToken()->getUser()->getProfesseurs(),
		// 	'contenu' => $data

		// ));
	}
}