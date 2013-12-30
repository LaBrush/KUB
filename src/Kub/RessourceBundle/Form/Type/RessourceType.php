<?php

namespace Kub\RessourceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Kub\RessourceBundle\Entity\Ressource ;
use Kub\RessourceBundle\Form\Type\FileType ;

use Kub\RessourceBundle\Form\EventListener\setTypeFieldSuscriber ;

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
			->add('matiere', 'entity', array(
				"class" => "Kub\EDTBundle\Entity\Matiere"
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
			'data_class' => 'Kub\RessourceBundle\Entity\Ressource'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'kub_ressourcebundle_ressource';
	}
}
