<?php

namespace Kub\CollaborationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Kub\CollaborationBundle\Entity\Fichier ;

class FichierType extends AbstractType
{
		/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name', 'text', array(
				'label' => 'Nom du fichier'
			))
			->add('type', 'choice', array(

				'choices' => array(
					Fichier::PAD => "Etherpad (traitement de texte)",
					Fichier::CALC => "Ethercalc (Tableur)"
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
			'data_class' => 'Kub\CollaborationBundle\Entity\Fichier'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'kub_collaborationbundle_fichier';
	}
}
