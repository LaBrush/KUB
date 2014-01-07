<?php

namespace Kub\MessagerieBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Kub\MessagerieBundle\Form\EventListener\addThreadFieldSuscriber ;

class MessageType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('contenu', 'genemu_tinymce')
			->addEventSubscriber(new addThreadFieldSuscriber($this->security));
		;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Kub\MessagerieBundle\Entity\Message'
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
