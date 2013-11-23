<?php

namespace Kub\NotesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Kub\NotesBundle\Form\Type\NoteSingleType ;
use Kub\NotesBundle\Entity\Note ;

class NoteGroupeType extends AbstractType
{

	private $groupe ;

	public function __construct(\Kub\ClasseBundle\Entity\Groupe $groupe)
	{
		$this->groupe = $groupe ;
	}

	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$eleves = $this->groupe->getEleves();

		for($i = 0 ; $i < count($eleves) ; $i++) {

			$note = new Note ;
			$note->setEleve($eleves[$i]);

			$builder->add($i, new NoteSingleType($note), array(
				"mapped" => false,
				"label" => $eleves[$i]
			)); 
		}
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Kub\NotesBundle\Entity\Note'
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
