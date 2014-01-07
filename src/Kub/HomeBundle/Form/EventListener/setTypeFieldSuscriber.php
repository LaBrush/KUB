<?php

namespace Kub\HomeBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Kub\HomeBundle\Entity\Ressource ;

class setTypeFieldSuscriber implements EventSubscriberInterface
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

		if ($this->data->getId()) {

			$this->form->remove('type');
		
			switch ($this->data->getType()) {
				case Ressource::WEB:
					$this->form->remove('file');
					break;
				case Ressource::FILE:
					$this->form->remove('url');
					break;
				default:
					throw new \Exception($this->data->getType());
					break;
			}

		}
	}
}