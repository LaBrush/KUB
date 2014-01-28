<?php

namespace Kub\MessagerieBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ThreadType extends AbstractType
{
	private $arg ;

	public function __construct($arg)
	{
		$this->arg = $arg ;
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
				"multiple" => true,
				'mapped' => false
			))
		;

		$sender = get_class($this->arg) == 'Kub\MessagerieBundle\Entity\Message' ? $this->arg->getSender() : $this->arg->getToken()->getUser() ;

		switch ($sender->getClass()) {
			case 'eleve':
			case 'professeur':
				$builder->add('groupes', 'genemu_jqueryselect2_entity', array(
					"choices" => $sender->getGroupes(),
					"class" => "Kub\ClasseBundle\Entity\Groupe",
					"label" => "Et le(s) groupe(s)",
					"multiple" => true,
					'mapped' => false
				));
				break;
			case 'administrateur':
				$builder->add('groupes', 'genemu_jqueryselect2_entity', array(
					"label" => "Et le(s) groupe(s)",
					"class" => "Kub\ClasseBundle\Entity\Groupe",
					"multiple" => true,
					'mapped' => false
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
