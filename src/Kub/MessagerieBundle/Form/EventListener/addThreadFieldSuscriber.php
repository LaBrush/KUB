<?php

namespace Kub\MessagerieBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Kub\MessagerieBundle\Form\Type\ThreadType ;

class addThreadFieldSuscriber implements EventSubscriberInterface
{
	private $data ;
	private $form ;

	public static function getSubscribedEvents()
	{
		return array(FormEvents::PRE_SET_DATA => 'preSetData');
	}

	public function preSetData(FormEvent $event)
	{
		$this->data = $event->getData();
		$this->form = $event->getForm();

		$this->form->add('thread_add_member', new ThreadType($this->data), array(
			"mapped" => false
		));
	}
}