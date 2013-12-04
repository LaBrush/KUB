<?php

namespace Kub\AbsenceBundle\Form\Type ;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Kub\AbsenceBundle\Form\Type\AbsenceType ;

class AppelType extends AbstractType
{

	private $groupes ;

	public  function __construct($groupes)
	{
		$this->groupes = $groupes ;
	}

	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{

		

	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Kub\AbsenceBundle\Entity\Appel'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'kub_absencebundle_appel';
	}
}
