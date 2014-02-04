<?php

namespace Kub\CollaborationBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

use Kub\CollaborationBundle\Entity\Permission ;

class ProjetHandler
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
	 * @param $manager
	 * 
	 */
	public function __construct(Form $form, Request $request, $em, $notifications)
	{
		$this->form = $form;
		$this->request = $request;
		$this->em = $em;
		$this->notifications = $notifications;
	}

	public function process()
	{
		if('POST' == $this->request->getMethod())
		{
			$this->form->bind($this->request);

			if($this->form->isValid())
			{
				$data = $this->form->getData();
				$permissions = array();

				foreach($this->form->get('permissions')->all() as $form) {
					$permission = $form->getData() ;

				    if (!array_key_exists($permission->getUser()->getUsername(), $permissions) && $permission->getUser()->getClass() != 'administrateur') {
				        $permissions[ $permission->getUser()->getUsername() ] = $permission;
				        $data->addPermission( $permission );
				    }
				}

				$this->onSuccess($data, $permissions);

				return true;
			}
		}

		return false;
	}

	protected function onSuccess($data, $permissions)
	{
		$this->em->persist($data);
		$this->em->flush();

		// foreach ($permissions as $permission) {
		// 	if($permission->getNotification() == null && $permission->getRole() != Permission::ADMINISTRATEUR)
		// 	{
		// 		$this->notifications->addNotification('PermissionProjetNotification', array(

		// 				"userTarget" => $permission->getUser(),
		// 				"permission" => $permission

		// 		)) ;
		// 	}
		// }
	}
}