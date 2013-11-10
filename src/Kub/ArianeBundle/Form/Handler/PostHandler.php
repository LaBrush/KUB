<?php

namespace Kub\ArianeBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

use Kub\UserBundle\Entity\Eleve ;

class PostHandler
{
	protected $request;
	protected $form;
	protected $em;
	protected $eleve ;

	/**
	 * Initialize the handler with the form and the request
	 *
	 * @param Form $form
	 * @param Request $request
	 * @param $em
	 * 
	 */
	public function __construct(Form $form, Request $request, $em, Eleve $eleve)
	{
		$this->form = $form;
		$this->request = $request;
		$this->em = $em;
		$this->eleve = $eleve ;
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
		$data->setFil( $this->eleve->getFil() );

		$this->em->persist($data);
		$this->em->flush();
	}
}