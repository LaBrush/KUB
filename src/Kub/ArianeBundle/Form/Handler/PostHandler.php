<?php

namespace Kub\ArianeBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

use Kub\ArianeBundle\Entity\Fil ;

class PostHandler
{
	protected $request;
	protected $form;
	protected $em;
	protected $fil ;
	protected $notification ;
	protected $security ;

	public function __construct(Form $form, Request $request, $em, Fil $fil, $notification, $security)
	{
		$this->form = $form;
		$this->request = $request;
		$this->em = $em;
		$this->fil = $fil ;
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
				$data = $this->form->getData();
				$this->onSuccess($data);

				return true;
			}
		}

		return false;
	}

	protected function onSuccess($data)
	{
		$data->setFil( $this->fil );

		$this->em->persist($data);
		$this->em->flush();

		$this->notification->addNotification('ArianePostNotification', array(

			'userTarget' => $this->security->getToken()->getUser()->getProfesseurs(),
			'contenu' => $data

		));
	}
}