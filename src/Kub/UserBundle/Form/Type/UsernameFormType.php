<?php

namespace Kub\UserBundle\Form\Type;

use FOS\UserBundle\Form\DataTransformer\UserToUsernameTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Form type for representing a UserInterface instance by its username string.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class UsernameFormType extends AbstractType
{
	/**
	 * @var UserToUsernameTransformer
	 */
	protected $usernameTransformer;

	/**
	 * Constructor.
	 *
	 * @param UserToUsernameTransformer $usernameTransformer
	 */
	public function __construct(UserToUsernameTransformer $usernameTransformer)
	{
		$this->usernameTransformer = $usernameTransformer;
	}

	/**
	 * @see Symfony\Component\Form\AbstractType::buildForm()
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->addModelTransformer($this->usernameTransformer);
	}

	/**
	 * @see Symfony\Component\Form\AbstractType::getParent()
	 */
	public function getParent()
	{	
		return 'genemu_jqueryselect2_choice';
	}

	/**
	 * @see Symfony\Component\Form\FormTypeInterface::getName()
	 */
	public function getName()
	{
		return 'kub_user_username';
	}
}