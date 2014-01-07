<?php

namespace Kub\AbsenceBundle\Form\Handler ;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

use Kub\AbsenceBundle\Entity\Absence ;

class AppelHandler
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
		$appel = $this->form->getData();

		foreach ($appel->getAbsences() as $absence) {
			
			if($absence->getStatut() == Absence::PRESENT)
			{
				$appel->removeAbsence($absence);
				$this->em->remove($absence);
			}

		}

		$this->em->persist($appel);
		$this->em->flush();

		return true ;
	}
}