<?php

namespace Kub\MessagerieBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ThreadType extends AbstractType
{
	private $commentaire ;

	public function __construct($commentaire)
	{
		$this->commentaire = $commentaire ;
	}

	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('users', 'genemu_jqueryselect2_entity', array(
				'class' => "Kub\UserBundle\Entity\User",
				'label' => "Pour",
				"multiple" => true
			))
		;

		$sender = $this->commentaire->getSender();
		switch ($sender->getClass()) {
			case 'eleve':
			case 'professeur':
				$builder->add('groupes', 'genemu_jqueryselect2_entity', array(
					"choices" => $sender->getGroupes(),
					"class" => "Kub\ClasseBundle\Entity\Groupe",
					"label" => "Et le(s) groupe(s)",
					"multiple" => true
				));
				break;
			case 'administrateur':
				$builder->add('groupes', 'genemu_jqueryselect2_entity', array(
					"label" => "Et le(s) groupe(s)",
					"class" => "Kub\ClasseBundle\Entity\Groupe",
					"multiple" => true
				));
				break;
		}

	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Kub\MessagerieBundle\Entity\Thread'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'kub_arianebundle_message';
	}
}
