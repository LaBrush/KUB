<?php

namespace Kub\CollaborationBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

use Kub\CollaborationBundle\Entity\ListeTaches ;
use Kub\CollaborationBundle\Entity\Organisateur ;

class TacheHandler
{
	protected $request;
	protected $form;
	protected $em;
	protected $organisateur;

	public function __construct(Form $form, Request $request, $em, Organisateur $organisateur)
	{
		$this->form = $form;
		$this->request = $request;
		$this->em = $em;
		$this->organisateur = $organisateur ;
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
		$this->em->persist($data);
		$this->em->flush();
	}
}