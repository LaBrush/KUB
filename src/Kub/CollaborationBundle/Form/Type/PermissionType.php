<?php

namespace Kub\CollaborationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Kub\CollaborationBundle\Entity\Permission ;

class PermissionType extends AbstractType
{
		/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('user')
			->add('role', 'choice', array(

				"choices" => array(
					Permission::VISITEUR => "Visiteur",
					Permission::CONTRIBUTEUR => "Contributeur",
					Permission::ADMINISTRATEUR => "Administrateur"
				)
			))
		;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Kub\CollaborationBundle\Entity\Permission'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'kub_collaborationbundle_permission';
	}
}
