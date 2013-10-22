<?php

namespace Kub\UserBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class GroupeHandler
{
	protected $request;
	protected $form;
	protected $em;


	/**
	 * Initialize the handler with the form and the request
	 *
	 * @param Form $form
	 * @param Request $request
	 * @param $manager
	 * 
	 */
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
		$em->persist($data);
		$em->flush();
	}
}