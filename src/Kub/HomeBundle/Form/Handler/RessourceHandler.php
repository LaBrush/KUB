<?php

namespace Kub\HomeBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Kub\RessourceBundle\Entity\Ressource;
use Symfony\Component\Form\FormError;

class RessourceHandler
{
	protected $request;
	protected $form;
	protected $em;
	protected $security ;
	protected $validator ;

	public function __construct(Form $form, Request $request, $em, $security, $validator)
	{
		$this->form = $form;
		$this->request = $request;
		$this->em = $em;
		$this->security = $security ;
		$this->validator = $validator ;
	}

	public function process()
	{	
		if('POST' == $this->request->getMethod())
		{
			$this->form->bind($this->request);

			// Puis on lance la validation
			if($this->form->isValid())
			{
				$data = $this->form->getData();
				$errorList = array();

				switch ($data->getType()) {
					case Ressource::FILE:
						$errorList = $this->validator->validate($data, array('file'));
						break;
					
					case Ressource::WEB:
						$errorList = $this->validator->validate($data, array('web'));
						break;

					default:
						$this->form->get('type')->addError(new FormError("La resssrouce n'a aucun type valide"));
						break;
				}
				
 
				foreach ($errorList as $error) {
					$this->form->get('type')->addError(new FormError($error->getMessage()));
				}

				if(!count($errorList))
				{
					$this->onSuccess( $data );
					return true;

				}
			}
		}

		return false;
	}

	protected function onSuccess($data)
	{
		$user = $this->security->getToken()->getUser() ;
		$data->setDepositaire($user);
		
		switch ($data->getType()) {
			case Ressource::WEB:
				$data->setFile();
				break;
			case Ressource::FILE:
				$data->setUrl( $data->getFile()->getWebPath() );
				break;
		}

		$this->em->persist($data);
		$this->em->flush();

		$this->postSuccess($data);
	}

	protected function postSuccess($data){


	}
}