<?php

namespace Kub\AbsenceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Kub\AbsenceBundle\Form\EventListener\addEleveFieldSuscriber ;


class AbsenceType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->addEventSubscriber(new addEleveFieldSuscriber());;
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
