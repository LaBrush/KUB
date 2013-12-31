<?php

namespace Kub\RessourceBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Kub\RessourceBundle\Entity\Ressource;
use Symfony\Component\Form\FormError;

class RessourceHandler
{
	protected $request;
	protected $form;
	protected $em;
	protected $notification ;
	protected $security ;
	protected $validator ;

	public function __construct(Form $form, Request $request, $em, $security, $notification, $validator)
	{
		$this->form = $form;
		$this->request = $request;
		$this->em = $em;
		$this->notification = $notification ;
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
				$errorList ;

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
					if($this->form->isValid())

					$this->onSuccess( $data );
					return true;

				}
			}
		}

		return false;
	}

	protected function onSuccess($data)
	{
		$this->em->persist($data);
		$this->em->flush();

		$user = $this->security->getToken()->getUser() ;

		$data->setDepositaire($user);
		$groupes = $user->getGroupes()->toArray();
		
		switch ($data->getType()) {
			case Ressource::WEB:
				$data->setFile();
				break;
			case Ressource::FILE:
				$data->setUrl( $data->getFile()->getWebPath() );
				break;
		}

		if($data->getValide())
		{
			foreach ($groupes as $groupe) {
				if($groupe->getNiveau()->getId() != $data->getNiveau()->getId())
				{
					if(($key = array_search($groupe, $groupes)) !== FALSE) {
						unset($groupes[$key]);
					}
				}
			}
		}

		$this->notification->addNotification('NewRessourceNotification', array(

			'groupesTarget' => $groupes,
			'ressource' => $data

		));
	}
}