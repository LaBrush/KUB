<?php

namespace Kub\MessageBundle\FormType ;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FOS\MessageBundle\FormType\NewThreadMessageFormType as BaseType ; 

class NewThreadMessageFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->remove('recipient')
            // ->add('recipient', 'checkbox', array(
            //     // 'choices' => $options['choices']
            //     'virtual' => true
            // ))
        ;

    }
}