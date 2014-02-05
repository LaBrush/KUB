<?php

namespace Kub\EDTBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Kub\EDTBundle\TimeService\TimeService ; 
use Symfony\Component\Form\FormError;

class CoursHandler
{
	protected $request;
	protected $form;
	protected $em;
	protected $validator ;
	protected $flashbag ;

	/**
	 * Initialize the handler with the form and the request
	 *
	 * @param Form $form
	 * @param Request $request
	 * @param $manager
	 * 
	 */
	public function __construct(Form $form, Request $request, $em, $validator, $flashbag)
	{
		$this->form      = $form;
		$this->request   = $request;
		$this->em        = $em;
		$this->validator = $validator ;
		$this->flashbag = $flashbag ;
	}

	public function process()
	{
	// Check the method
		if('POST' == $this->request->getMethod())
		{
			$this->form->bind($this->request);

			// On attribut les semaines de chaque cours en fonction des fréquences
			$liste_horaires_form = $this->form["horaires"];

			foreach ($liste_horaires_form as $horaire_form) {

				$horaire_form->getData()->setCours( $this->form->getData() );

				$liste_frequences = $horaire_form["frequences"]->getData();
				$horaire = $horaire_form->getData();

				foreach ($liste_frequences as $frequence) {
					foreach ($frequence->getSemaines() as $semaine) {
						$horaire->addSemaine($semaine);
					}
				}

			}

			// Puis on lance la validation
			if($this->form->isValid())
			{
				$errorList = $this->validator->validate($this->form->getData(), array('second_pass'));
 
				foreach ($errorList as $error) {
					$this->form->get("horaires")->addError(new FormError($error->getMessage()));
				}

				if(!count($errorList))
				{
					$data = $this->form->getData();
					$this->onSuccess($data);
					return true;
				}
				else
				{
					$this->flashbag->add('info', $this->form->getErrorsAsString());
				}
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