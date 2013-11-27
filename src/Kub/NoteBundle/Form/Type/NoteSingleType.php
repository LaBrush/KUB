<?php

namespace Kub\NoteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Kub\NoteBundle\Entity\Note ;

class NoteSingleType extends AbstractType
{
	public function __construct(Note $note)
	{
		$this->note = $note;
	}

	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('noter', 'checkbox', array(
				"mapped" => false,
				'attr'     => array('checked'   => 'checked'),
			))
			->add('note', 'number')
			->add('coefficient', 'number')
		;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'empty_data' => $this->note
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
