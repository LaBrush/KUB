<?php

namespace Kub\ArianeBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

use Kub\RessourceBundle\Entity\WebRessource ;
use Kub\RessourceBundle\Entity\FileRessource ;

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
				$data = $this->form->getData();
				$this->onSuccess($data);

				return true;
			}
		}

		return false;
	}

	protected function onSuccess($data)
	{
		$type = ucfirst( $data["type"]->getData() ) . 'Ressource ';
		$ressource = new $type ;

		// $this->em->persist($ressource);
		// $this->em->flush();

		// $this->notification->addNotification('ArianePostNotification', array(

		// 	'userTarget' => $this->security->getToken()->getUser()->getProfesseurs(),
		// 	'contenu' => $data

		// ));
	}
}