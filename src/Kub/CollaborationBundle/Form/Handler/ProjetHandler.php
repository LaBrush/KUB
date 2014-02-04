<?php

namespace Kub\CollaborationBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class ProjetHandler
{
	protected $request;
	protected $form;
	protected $em;


	/**
	 * Initialize the handler with the form and the request
	 *
	 * @param Form $form
	 * @param Request $request
	 * @param $manager
	 * 
	 */
	public function __construct(Form $form, Request $request, $em)
	{
		$this->form = $form;
		$this->request = $request;
		$this->em = $em;
	}

	public function process()
	{
		if('POST' == $this->request->getMethod())
		{
			$this->form->bind($this->request);

			if($this->form->isValid())
			{
				$data = $this->form->getData();

				$data->erasePermissions();
				$permissions = $data->getPermissions() ;

				foreach ($this->form->get('permissions')->all() as $form){
					
					$put = true ;
					$current = $form->getData();

					for($permissions as $permission)
					{
						if($permission == $current)
						{
							if($permission->getRole() >= $current->getRole())
							{
								$put = false ;
							}
							else {
								$data->removePermission($permission);
							}
						}
					}

					if($put)
					{
						$permissions[] = $permission ;
					}
				}
				


				$this->onSuccess($data);

				return true;
			}
		}

		return false;
	}

	protected function onSuccess($data)
	{
		$this->em->persist($data);
		$this->em->flush();
	}
}