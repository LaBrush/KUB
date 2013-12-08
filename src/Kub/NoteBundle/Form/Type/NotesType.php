<?php

namespace Kub\NoteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Kub\NoteBundle\Entity\Note ;

class NotesType extends AbstractType
{
	
	private $eleves ;

	public function __construct($eleves)
	{
		$this->eleves = $eleves ;
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		for($i = 0 ; $i < count($this->eleves) ; $i++) {

			$note = new Note ;
			$note->setEleve( $this->eleves[$i] );

			$builder->add($i, new NoteType(), array(
				"mapped" => false,
				"label" => $note->getEleve(),
				"data_class" => "Kub\NoteBundle\Entity\Note",
				"mapped" => false
			)); 
		}
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array());
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'kub_notesbundle_note';
	}
}
