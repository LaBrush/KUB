<?php

namespace Kub\RessourceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Kub\RessourceBundle\Entity\Ressource ;
use Kub\HomeBundle\Form\Type\RessourceType as BaseRessourceType ;

class RessourceType extends BaseRessourceType
{
		/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
		$builder
			->add('file', new FileType, array(
				"data_class" => "Kub\CollaborationBundle\Entity\File"
			))
			->add('niveau', 'entity', array(
				"class" => "Kub\ClasseBundle\Entity\Niveau"
			))
			->add('matiere', 'entity', array(
				"class" => "Kub\EDTBundle\Entity\Matiere"
			))
		;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'empty_data' => new Ressource,
			'data_class' => 'Kub\RessourceBundle\Entity\Ressource'
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
