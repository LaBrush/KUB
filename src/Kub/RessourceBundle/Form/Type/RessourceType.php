<?php

namespace Kub\RessourceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RessourceType extends AbstractType
{
		/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('titre')
			->add('description', "textarea")
			->add('type', 'choice', array(
				"expanded" => true,
				'choices' => array(
					"web" => "Ressouce en ligne",
					"file" => "Fichier"
				)
			))
			->add('url', 'url')
			->add('file', 'file')
		;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'empty_data' => true
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'kub_ressourcebundle_ressource';
	}
}
