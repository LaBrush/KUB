<?php

namespace Kub\AbsenceBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Kub\AbsenceBundle\Entity\Absence ;

class addEleveFieldSuscriber implements EventSubscriberInterface
{

	private $data ;
	private $form ;

	public static function getSubscribedEvents()
	{
		// Tells the dispatcher that you want to listen on the form.pre_set_data
		// event and that the preSetData method should be called.
		return array(FormEvents::PRE_SET_DATA => 'preSetData');
	}

	public function preSetData(FormEvent $event)
	{
		$this->data = $event->getData();
		$this->form = $event->getForm();

		$this->form->add('statut', 'choice', array(
			"choices" => array(

				Absence::PRESENT => "Présent",
				Absence::ABSENCE => "Absent",
				Absence::RETARD  => "En retard"

			),
			"label" => $this->data->getEleve()
		));
	}
}