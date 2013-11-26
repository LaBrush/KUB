<?php

namespace Kub\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Kub\UserBundle\Form\Type\TuteurCollectionType ;
use Kub\UserBundle\Form\Type\PhotoType ;

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

		for ($i=1973; $i < 2010 ; $i++) { 
			$years[] = $i ;
		}

		$builder
			->add('photo', new PhotoType(), array('required' => false))
			->add("anniversaire", "birthday", array(
				"years" => $years
			))
			->add('niveau', 'entity', array(
				"class" => "Kub\ClasseBundle\Entity\Niveau",
			))
			->add('tuteurs', 'genemu_jqueryselect2_entity', array(
					"class" => "Kub\UserBundle\Entity\Tuteur",
					"multiple" => true
				)
			)
			->add('tuteursAdd', 'collection', array(
				"type" => new TuteurCollectionType(),
				"allow_add" => true,
				"allow_delete" => true,
				"property_path" => "tuteurs"
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
