<?php

namespace Kub\CollaborationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TacheType extends AbstractType
{

	private $projet ;

	public function __construct($projet)
	{
		$this->projet = $projet ;
	}

	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$choices = array();
		$taches = $this->projet->getOrganisateur()->getListeTaches();

		for ($i=0; $i < count($taches); $i++) { 
			$choices[ $taches[$i]->getId() ] = $taches[$i];
		}

		$builder
			->add('name', 'text', array(
				'label' => 'Nom'
			))
			->add('echeance')
			->add('participants', 'genemu_jqueryselect2_entity', array(
				'choices' => $this->projet->getUsers(),
				'class' => 'Kub\UserBundle\Entity\User',
				'multiple' => true
			))
		;

		if(count($choices) > 0)
		{
			$builder->add('listeTaches', 'entity', array(
				'choices' => $choices,
				'class' => 'Kub\CollaborationBundle\Entity\ListeTaches',
				'label' => 'Ajouter à la liste'
			));
		}

		$builder->add('newListe', 'text', array(
				'mapped' => false,
				'label' => 'créer une nouvelle liste'
			))
		;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Kub\CollaborationBundle\Entity\Tache'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'kub_collaborationbundle_tache';
	}
}
