<?php

namespace Kub\NoteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Kub\NoteBundle\Entity\Note ;
use Kub\EDTBundle\Entity\CoursRepository ;

class NoteEleveType extends NoteType
{
	private $controles ;
	private $eleve ;
	private $professeur ;

	public function __construct($controles, $eleve, $professeur)
	{
		$this->controles = $controles ;
		$this->eleve = $eleve ;
		$this->professeur = $professeur ;
	}

	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);

		$note = array();
		$no_note = array();

		for ($i=0; $i < count($this->controles); $i++) { 
			if($this->controles[$i]->hasEleve( $this->eleve ))
			{
				$note[ $this->controles[$i]->getId() ] = (string)$this->controles[$i];
			}
			else
			{
				$no_note[ $this->controles[$i]->getId() ] = (string)$this->controles[$i];
			}
		}

		$builder
			->remove('noter')
			->add('controle', 'choice', array(

				'choices' => array(
					0 => 'Nouveau controle',
					'Controles ou l\'élève a déjà une note' => $note,
					'Controles ou l\'élève n\'a pas de note' => $no_note
				),
				'mapped' => false

			))
			->add('cours_new', 'entity', array(

				'mapped' => false,
				'class' => 'Kub\EDTBundle\Entity\Cours',
				'label' => 'Cours du nouveau controle',
				'property' => 'toStringProfesseur',
				'query_builder' => function (CoursRepository $er)
				 {
					return $er->createQueryBuilder('c')
						->join('c.professeur', 'p')
						->addSelect('p')
						->join('c.groupes', 'g')
						->addSelect('g')
						->join('g.eleves', 'e')
						->addSelect('e')
						
						->where('p.id = :pid')
						->setParameter('pid', $this->professeur->getId())
					
						->andWhere('e.id = :eid')
						->setParameter('eid', $this->eleve->getId())
					;
				 }

			))
			->add('name_new', 'text', array(

				'mapped' => false,
				'required' => false,
				'label' => 'Nom du controle'

			))
			->add('date_new', 'date', array(

				'mapped' => false,
				'required' => false,
				'label' => 'Date du controle',
				'data' => new \DateTime

			))
		;

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
