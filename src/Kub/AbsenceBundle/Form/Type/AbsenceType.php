<?php

namespace Kub\AbsenceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Kub\AbsenceBundle\Entity\Absence ;

class AbsenceType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('statut', 'choice', array(
				"choices" => array(

					Absence::PRESENT => "Présent",
					Absence::ABSENCE => "Absent",
					Absence::RETARD  => "En retard"

				)
			))
		;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Kub\AbsenceBundle\Entity\Absence'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'kub_absencebundle_absence';
	}
}
