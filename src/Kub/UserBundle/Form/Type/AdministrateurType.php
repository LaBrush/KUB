<?php

namespace Kub\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdministrateurType extends UserType
{

	private $security ;

	public function __construct($security)
	{	
		$this->security = $security;
	}

	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);

		$choices = array(
			"ROLE_SURVEILLANT" => "Surveillant",
			"ROLE_CPE" => "CPE",
		);

		if($this->security->isGranted("ROLE_MANITOU"))
		{
			$choices["ROLE_SECRETAIRE"] = "Secrétaire";
			$choices["ROLE_MANITOU"] = "Un Grand Manitou";
		}

		$builder
			->add("type", "choice",
				array(
					"mapped" => false,
					"choices" => $choices,
			))
		;

		return $builder ;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Kub\UserBundle\Entity\Administrateur'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'kub_userbundle_administrateur';
	}
}
