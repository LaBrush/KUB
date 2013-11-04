<?php

namespace Kub\EDTBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Kub\EDTBundle\Services\TimeService ;

class CoursHandler
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
		$this->form    = $form;
		$this->request = $request;
		$this->em      = $em;
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
		$liste_horaires_form = $this->form["horaires"];

		foreach ($liste_horaires_form as $key => $horaire_form) {

			$liste_frequences = $horaire_form["frequences"]->getData();
			$horaire = $horaire_form->getData();

			foreach ($liste_frequences as $key => $frequence) {
				foreach ($frequence->getSemaines() as $key => $semaine) {
					$horaire->addSemaine($semaine);
				}
			}

		}

		$this->em->persist($data);
		$this->em->flush();
	}
}