<?php

namespace Kub\CollaborationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProjetType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name')
			->add('dateFin')
			->add('description')
			->add('permissions', 'collection', array(
				'type' => new PermissionType
			))
		;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Kub\CollaborationBundle\Entity\Projet'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'kub_collaborationbundle_projet';
	}
}
