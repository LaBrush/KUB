<?php

namespace Kub\MessageBundle\FormFactory;

use FOS\MessageBundle\FormFactory\NewThreadMessageFormFactory as BaseFactory ;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormFactoryInterface;
use FOS\MessageBundle\FormModel\AbstractMessage;

/**
 * Instanciates message forms
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class NewThreadMessageFormFactory extends BaseFactory
{
	public function __construct(FormFactoryInterface $formFactory, AbstractType $formType, $formName, $messageClass, $em)
	{
		parent::__construct($formFactory, $formType, $formName, $messageClass);

		$this->formFactory = $formFactory;
		// $this->formType = $formType;
		$this->formType = new \Kub\MessageBundle\FormType\NewThreadMessageFormType ;
		$this->formName = $formName;
		$this->messageClass = $messageClass;

		$this->em = $em;
	}

	/**
	 * Creates a new thread message
	 *
	 * @return Form
	 */
	public function create()
	{
		$message = $this->createModelInstance();
		$user_list = $this->em->getRepository('KubUserBundle:User')->finAllWithNames();
		$user_list_options = array();

		for ($i = 0 ; $i < count($user_list) ; $i++) { 
			$user_list_options[ $user_list[$i]["username"] ] = $user_list[$i]["prenom"] . ' ' . $user_list[$i]["nom"];
		}
		
		return $this->formFactory->createNamed($this->formName, $this->formType, $message);//, array("choices" => $user_list_options));
	}
}