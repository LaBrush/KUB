<?php

namespace Kub\UserBundle\Form\EventListener ;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class addRoleFieldSuscriber implements EventSubscriberInterface
{

	private $data ;
	private $form ;
	private $security ;

	public function __construct($security)
	{
		$this->security = $security ;
	}

	public static function getSubscribedEvents()
	{
		return array(FormEvents::POST_SET_DATA => 'postSetData');
	}

	public function postSetData(FormEvent $event)
	{
		$this->data = $event->getData();
		$this->form = $event->getForm();

		$choices = array(
			"ROLE_SURVEILLANT" => "Surveillant",
			"ROLE_CPE" => "CPE",
		);

		if($this->security->isGranted("ROLE_MANITOU"))
		{
			$choices["ROLE_SECRETAIRE"] = "Secrétaire";
			$choices["ROLE_MANITOU"] = "Un Grand Manitou";
		}

		$preferred = "ROLE_SURVEILLANT";

			   if( $this->form->getData()->hasRole("ROLE_MANITOU") ) {
			$preferred = "ROLE_MANITOU" ;
		} else if( $this->form->getData()->hasRole("ROLE_SECRETAIRE") ) {
			$preferred = "ROLE_SECRETAIRE" ;
		} else if( $this->form->getData()->hasRole("ROLE_CPE") ) {
			$preferred = "ROLE_CPE" ;
		}

		$this->form->add('type', 'choice', array(

			"mapped" => false,
			'choices' => $choices,
    		'preferred_choices' => array($preferred),

		));
	}
}