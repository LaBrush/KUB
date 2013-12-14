<?php

namespace Kub\UserBundle\Form\Handler ;


class EleveHandler extends UserHandler
{

	// public function process()
	// {

	// 	if('POST' == $this->request->getMethod())
	// 	{
	// 		$this->form->bind($this->request);

	// 		if($this->form->isValid())
	// 		{
	// 			$data = $this->form->getData();
	// 			$tuteurs = $this->form->all();

	// 			ob_start();

	// 			foreach ($tuteurs as $tuteur) {
	// 				echo $tuteur->getName() . '  ';
	// 			}

	// 			throw new \Exception(ob_get_clean());		

	// 			for ($i=0; $i < count($tuteurs) ; $i++) { 
	// 				$data->addTuteur( $tuteurs[$i] );
	// 				$tuteurs[$i]->addEleve( $data );
	// 			}


	// 			$this->onSuccess($data);

	// 			return true;
	// 		}
	// 	}

	// 	return false;
	// }

}
