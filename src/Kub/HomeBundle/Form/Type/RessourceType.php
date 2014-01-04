<?php

namespace Kub\HomeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Kub\HomeBundle\Entity\Ressource ;
use Kub\HomeBundle\Form\Type\FileType ;

use Kub\HomeBundle\Form\EventListener\setTypeFieldSuscriber ;

class RessourceType extends AbstractType
{
		/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('titre', 'text')
			->add('auteur', 'text')
			->add('description', "textarea")
			->add('niveau', 'entity', array(
				"class" => "Kub\ClasseBundle\Entity\Niveau"
			))
			->add('type', 'choice', array(
				"expanded" => true,
				'choices' => array(
					Ressource::WEB => "Ressource en ligne",
					Ressource::FILE => "Fichier"
				)
			))
			->add('url', 'url')
			->add('file', new FileType)
			->addEventSubscriber(new setTypeFieldSuscriber)
		;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'empty_data' => new Ressource,
			'data_class' => 'Kub\HomeBundle\Entity\Ressource'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'kub_HomeBundle_ressource';
	}
}
