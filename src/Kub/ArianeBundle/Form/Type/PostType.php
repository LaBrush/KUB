<?php

namespace Kub\ArianeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostType extends AbstractType
{
		/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('debut', 'date')
			->add('titre', 'text', array(
				'label' => 'Titre de la trace :'
			))
			->add('contenu', 'genemu_tinymce')
		;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Kub\ArianeBundle\Entity\Post'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'kub_arianebundle_post';
	}
}
