<?php

namespace Kub\NoteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Kub\NoteBundle\Entity\Note ;
use Kub\NoteBundle\Form\EventListener\addEleveFieldSuscriber ;

class NoteType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		->add('noter', 'checkbox', array(
			'required' => false
		))
		->add('coefficient', 'number', array(
			'required' => false
		))
		->addEventSubscriber(new addEleveFieldSuscriber());
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Kub\NoteBundle\Entity\Note'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'kub_notesbundle_note';
	}
}
