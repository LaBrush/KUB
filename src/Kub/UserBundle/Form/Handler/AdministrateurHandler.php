<?php

namespace Kub\UserBundle\Form\Handler ;


class AdministrateurHandler extends UserHandler
{
	public function process()
	{
		if('POST' == $this->request->getMethod())
		{
			$this->form->bind($this->request);

			if($this->form->isValid())
			{
				$data = $this->form->getData();

				$type = $this->form->get('type')->getData();
				
				$data->setRoles( array( $type, "ROLE_ADMINISTRATEUR" ));				
				$this->onSuccess($data);

				return true;
			}
		}

		return false;
	}
}
