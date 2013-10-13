<?php

namespace Kub\UserBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use PUGX\MultiUserBundle\Model\UserDiscriminator;

class UserHandler
{
	protected $request;
	protected $form;
	protected $em;
	protected $discriminator ;
	protected $userManager ;


	/**
	 * Initialize the handler with the form and the request
	 *
	 * @param Form $form
	 * @param Request $request
	 * @param $manager
	 * 
	 */
	public function __construct(Form $form, Request $request, $em, UserDiscriminator $discriminator, $userManager)
	{
		$this->form = $form;
		$this->request = $request;
		$this->em = $em;

		$this->discriminator = $discriminator ;
		$this->userManager = $userManager ;
	}

	public function process()
	{
	// Check the method
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
		$data->setEnabled(true);
		$this->userManager->updateCanonicalFields($data);

		$this->userManager->updatePassword($data);
		$this->userManager->updateUser($data, true);
	}
}