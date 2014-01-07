<?php

namespace Kub\CollaborationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TacheType extends AbstractType
{

	private $projet

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
		$builder
			->add('name')
			->add('echeance')
			->add('participants', 'entity', array(

				'choices' => $this->projet->getUsers(),
				"data_class" => "Kub\CollaborationBundle\Entity\ListeTaches"

			))
			->add('tache', 'entity', array(

				'choices' => $this->projet->getOrganisateur()->getListeTaches(),
				"data_class" => "Kub\CollaborationBundle\Entity\ListeTaches"

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
