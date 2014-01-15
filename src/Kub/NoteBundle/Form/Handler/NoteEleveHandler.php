<?php

namespace Kub\NoteBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

use Kub\NoteBundle\Entity\Controle ;

class NoteEleveHandler
{
	protected $request;
	protected $form;
	protected $em;
	protected $notifications;

	/**
	 * Initialize the handler with the form and the request
	 *
	 * @param Form $form
	 * @param Request $request
	 * @param $em
	 * 
	 */
	public function __construct(Form $form, Request $request, $em, $notifications)
	{
		$this->form = $form;
		$this->request = $request;
		$this->em = $em;
		$this->notifications = $notifications ;
	}

	public function process()
	{
		if('POST' == $this->request->getMethod())
		{
			$this->form->bind($this->request);

			if($this->form->isValid())
			{
				return $this->onSuccess();
			}
		}

		return false;
	}

	private function onSuccess()
	{
		$note = $this->form->getData();

		$id = $this->form->get('controle')->getData();
		if($id == 0)
		{
			$controle = new Controle ;
				$controle->setCours( $this->form->get('cours_new')->getData()    );
				$controle->setName(  $this->form->get('name_new')->getData()  );
				$controle->setDate(  $this->form->get('date_new')->getData() );

			$notes = $controle->getNotes();

			for ($i=0; $i < count($notes) ; $i++) { 
				if($notes[$i]->getEleve()->getId() == $note->getEleve()->getId())
				{
					$controle->removeNote($notes[$i]);
					break;
				}
			}

			$controle->addNote($note);
		}
		else
		{
			$this->em->getRepository('KubNoteBundle:Controle')->findOneById($id);
		}



		$this->em->persist($controle);
		$this->em->flush();

		foreach ($controle->getNotes() as $note) {
			$this->notifications->addNotification('NoteAddedNotification', array(

					"userTarget" => $note->getEleve(),
					"note" => $note

			)) ;
		}
		
		return true ;
	}
}