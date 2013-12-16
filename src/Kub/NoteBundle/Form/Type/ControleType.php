<?php

namespace Kub\NoteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Kub\NoteBundle\Form\Type\NoteType ;
use Kub\NoteBundle\Entity\Note ;

use Kub\NoteBundle\Form\EventListener\addEleveFieldSuscriber;
use Kub\EDTBundle\Entity\MatiereRepository ;

class ControleType extends AbstractType
{

	private $professeur ;
	private $cours ;
	private $eleves ;

	public function __construct(\Kub\UserBundle\Entity\Professeur $professeur, \Kub\EDTBundle\Entity\Cours $cours)
	{
		$this->professeur = $professeur ;
		$this->cours = $cours ;

		$this->eleves = array();
		foreach ($this->cours->getGroupes() as $groupe) {
			foreach ($groupe->getEleves() as $eleve) {
				$this->eleves[] = $eleve ;
			}
		}
	}

	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		->add('nom', 'text', array(
			'label' => 'Intitulé du DS'
		))
		->add('notes', new NotesType( $this->eleves ));

	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Kub\NoteBundle\Entity\Controle'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'kub_notesbundle_controle';
	}
}
