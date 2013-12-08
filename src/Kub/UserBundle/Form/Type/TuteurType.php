<?php

namespace Kub\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use libphonenumber\PhoneNumberFormat;

class TuteurType extends UserType
{
		/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
			$builder
				->add('fixe', 'tel', array('required' => false, 'default_region' => 'FR', 'format' => PhoneNumberFormat::NATIONAL))
				->add('mobile', 'tel', array('required' => false, 'default_region' => 'FR', 'format' => PhoneNumberFormat::NATIONAL))
				->add("adresse", 'text', array('required' => false))
				->add('eleves', 'genemu_jqueryselect2_entity', array(
						"mapped" => true,
						"class" => "Kub\UserBundle\Entity\Eleve",
						"multiple" => true
					)
				);

		return $builder ;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Kub\UserBundle\Entity\Tuteur'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'kub_userbundle_tuteur';
	}
}
