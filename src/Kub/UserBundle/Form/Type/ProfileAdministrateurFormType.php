<?php

namespace Kub\UserBundle\Form\Type ;

use Kub\UserBundle\Form\Type\ProfileUserFormType as baseType ;
use Symfony\Component\Form\FormBuilderInterface ;

class ProfileAdministrateurFormType extends baseType
{

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);

		$builder
			->add('nom')
			->add('prenom')
		;
	}

}