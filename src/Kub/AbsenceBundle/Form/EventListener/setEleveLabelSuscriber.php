<?php

namespace Kub\AbsenceBundle\Form\EventListener ;


use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Kub\AbsenceBundle\Form\Type\AbsenceType ;

class setEleveLabelSuscriber implements EventSubscriberInterface
{

	private $data ;
	private $form ;

	public static function getSubscribedEvents()
	{
		// Tells the dispatcher that you want to listen on the form.pre_set_data
		// event and that the preSetData method should be called.
		return array(FormEvents::POST_SET_DATA => 'preSetData');
	}

	public function preSetData(FormEvent $event)
	{
		$this->data = $event->getData();
		$this->form = $event->getForm();

		$this->form->
	}
}