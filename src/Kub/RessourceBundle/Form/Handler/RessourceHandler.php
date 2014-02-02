<?php

namespace Kub\RessourceBundle\Form\Handler;

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
		$this->notification = $notification ;

	}

	protected function postSuccess($data)
	{
		$user = $this->security->getToken()->getUser();

		if($data->getValide())
		{
			$groupes = $user->getGroupes()->toArray();

			foreach ($groupes as $groupe) {
				if($groupe->getNiveau()->getId() != $data->getNiveau()->getId())
				{
					if(($key = array_search($groupe, $groupes)) !== FALSE) {
						unset($groupes[$key]);
					}
				}
			}

			if(count($groupes) > 0)
			{
				$this->notification->addNotification('NewRessourceNotification', array(

					'groupesTarget' => $groupes,
					'ressource' => $data

				));
			}
		}
	}

}