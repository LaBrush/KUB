<?php

namespace Kub\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Kub\UserBundle\Form\Type\TuteurType ;

class EleveType extends UserType
{
		/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
		
		$years = array();

		for ($i=1990; $i < 2010 ; $i++) { 
			$years[] = $i ;
		}

		$builder
			->add("anniversaire", "date", array(
				"years" => $years
			))
			->add('niveau', 'entity', array(
				"class" => "Kub\UserBundle\Entity\Niveau",
			))
			->add('tuteurs', 'collection', array(
				"type" => new TuteurType(),
				"allow_add" => true,
				"allow_delete" => true
			))
			->add('tuteurs', 'entity', array(
				'class' => 'Kub\UserBundle\Entity\Tuteur',
				"multiple" => true,
				"expanded" => true
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
			'data_class' => 'Kub\UserBundle\Entity\Eleve'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'kub_userbundle_eleve';
	}
}
