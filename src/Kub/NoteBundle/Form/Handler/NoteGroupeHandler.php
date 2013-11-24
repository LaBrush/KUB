<?php

namespace Kub\NoteBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class NoteGroupeHandler
{
	protected $request;
	protected $form;
	protected $em;

	/**
	 * Initialize the handler with the form and the request
	 *
	 * @param Form $form
	 * @param Request $request
	 * @param $em
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
				return $this->onSuccess();
			}
		}

		return false;
	}

	private function onSuccess()
	{
		$matiere = $this->form['matiere']->getData();
		for ($i = 0; $i < count($this->form)-1 ; $i++) {

			$this->form[$i]->getData()->setMatiere( $matiere ); 

			$handler = new NoteSingleHandler($this->form[$i], $this->request, $this->em);

			if(!$handler->process())
			{
				return false ;
			}	
		}

		return true ;
	}
}