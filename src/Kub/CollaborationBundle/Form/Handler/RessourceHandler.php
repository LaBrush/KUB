<?php

namespace Kub\CollaborationBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Kub\RessourceBundle\Entity\Ressource;
use Symfony\Component\Form\FormError;

use Kub\HomeBundle\Form\Handler\RessourceHandler as BaseHandler;

class RessourceHandler extends BaseHandler
{
	protected $notification ;

	public function __construct(Form $form, Request $request, $em, $security, $validator, $notification)
	{
		parent::__construct($form, $request, $em, $security, $validator, $notification);
		$this->validator = $validator ;

	}

	protected function postSuccess($data)
	{
		$user = $this->security->getToken()->getUser();

			// $this->notification->addNotification('NewRessourceNotification', array(

			// 	'groupesTarget' => $groupes,
			// 	'ressource' => $data

			// ));
	}

}