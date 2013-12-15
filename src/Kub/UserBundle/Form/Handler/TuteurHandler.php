<?php

namespace Kub\UserBundle\Form\Handler ;


class TuteurHandler extends UserHandler
{
	// public function process()
	// {
	// 	if('POST' == $this->request->getMethod())
	// 	{
	// 		$this->form->bind($this->request);

	// 		if($this->form->isValid())
	// 		{
	// 			$data = $this->form->getData();
	// 			$eleves = $this->form->get('eleves')->getData();

				
	// 			for ($i=0; $i < count($eleves) ; $i++) { 
	// 				$data->addEleve( $eleves[$i] );
	// 				$eleves[$i]->addTuteur( $data );
	// 			}


	// 			$this->onSuccess($data);

	// 			return true;
	// 		}
	// 	}

	// 	return false;
	// }
}
