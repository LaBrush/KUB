 <?php

namespace Kub\UserBundle\Form\Type ;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType ;
use Symfony\Component\Form\FormBuilderInterface ;
use FOS\UserBundle\Form\Type\ChangePasswordFormType;

class ProfileUserFormType extends BaseType {

	private $class ;

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('email', 'email', array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
		;

	}

}