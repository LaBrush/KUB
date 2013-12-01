<?php

namespace Kub\NoteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Kub\NoteBundle\Form\Type\NoteType ;
use Kub\NoteBundle\Entity\Note ;

use Kub\EDTBundle\Entity\MatiereRepository ;

class ControleType extends AbstractType
{

	private $professeur ;
	private $groupe ;

	public function __construct(\Kub\UserBundle\Entity\Professeur $professeur, \Kub\ClasseBundle\Entity\Groupe $groupe)
	{
		$this->professeur = $professeur ;
		$this->groupe = $groupe ;
	}

	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		->add('nom')
		->add('matiere', 'entity', array(
			'class' => 'Kub\EDTBundle\Entity\Matiere',
			"multiple" => false,
			"expanded" => false,
			'query_builder' => function(MatiereRepository $er) {

				return $er->createQueryBuilder('m')
					->join('m.cours', 'c')
					->join('c.professeur', 'p')
					->where('p.id = :p_id')
					->setParameter('p_id', $this->professeur->getId())
					->join('c.groupes', 'g')
					->andWhere('g.id = :g_id')
					->setParameter('g_id', $this->groupe->getId())
				;
			}
		))
		->add('notes', 'collection', array(
			'type' => new NoteType
		));

		// for($i = 0 ; $i < count($this->eleves) ; $i++) {

		// 	$note = new Note ;
		// 	$note->setEleve($this->eleves[$i]);
		// 	$note->setProfesseur( $this->professeur );

		// 	$builder->add($i, new NoteType($note), array(
		// 		"mapped" => false,
		// 		"label" => $this->eleves[$i],
		// 		"data_class" => "Kub\NoteBundle\Entity\Note"
		// 	)); 
		// }
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
