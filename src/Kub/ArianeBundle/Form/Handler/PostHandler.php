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

	/**
	 * Initialize the handler with the form and the request
	 *
	 * @param Form $form
	 * @param Request $request
	 * @param $em
	 * 
	 */
	public function __construct(Form $form, Request $request, $em, Fil $fil)
	{
		$this->form = $form;
		$this->request = $request;
		$this->em = $em;
		$this->fil = $fil ;
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
	}
}