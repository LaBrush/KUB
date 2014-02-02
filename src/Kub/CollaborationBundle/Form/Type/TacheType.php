<?php

namespace Kub\CollaborationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TacheType extends AbstractType
{

	private $projet ;

	public function __construct($projet)
	{
		$this->projet = $projet ;
	}

	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$choices = array();
		$taches = $this->projet->getOrganisateur()->getListeTaches();

		for ($i=0; $i < count($taches); $i++) { 
			$choices[ $taches[$i]->getId() ] = $taches[$i];
		}

		$builder
			->add('name', 'text', array(
				'label' => 'Nom'
			))
			->add('notes', 'textarea', array(
				'label' => 'Notes complémentaires'
			))
			->add('echeance')
			->add('participants', 'genemu_jqueryselect2_entity', array(
				'choices'  => $this->projet->getUsers(),
				'class'    => 'Kub\UserBundle\Entity\User',
				'multiple' => true
			))
			->add('ressources', 'genemu_jqueryselect2_entity', array(
				'choices'  => $this->projet->getDocumentheque()->getRessources(),
				'class'    => 'Kub\CollaborationBundle\Entity\Ressource',
				'multiple' => true,
				'label'    => 'Ressources associées'
			))
			->add('fichiers', 'genemu_jqueryselect2_entity', array(
				'choices'  => $this->projet->getDocumentheque()->getFichiers(),
				'class'    => 'Kub\CollaborationBundle\Entity\Fichier',
				'multiple' => true,
				'label'    => 'Fichiers associés'
			))
		;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Kub\CollaborationBundle\Entity\Tache'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'kub_collaborationbundle_tache';
	}
}
