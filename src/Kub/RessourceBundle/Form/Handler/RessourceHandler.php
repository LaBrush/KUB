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

		$groupes = $this->security->getToken()->getUser()->getGroupes();
		foreach ($groupes as $groupe) {
			if($groupe->getNiveau()->getId() != $data->getNiveau()->getId())
			{
				if(($key = array_search($groupe, $groupes)) !== FALSE) {
					unset($groupes[$key]);
				}
			}
		}

		$this->notification->addNotification('NewRessourceNotification', array(

			'groupesTarget' => $groupes,
			'ressource' => $data

		));
	}
}