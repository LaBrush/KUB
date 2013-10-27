<?php

namespace Kub\ClasseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Kub\ClasseBundle\Form\EventListener\addMemberFieldSuscriber ;

class GroupeType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('niveau', "entity", array(
                "multiple" => false,
                "expanded" => true,
                "class" => "Kub\ClasseBundle\Entity\Niveau"
            ))
            ->addEventSubscriber(new addMemberFieldSuscriber());
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kub\ClasseBundle\Entity\Groupe'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'kub_classebundle_groupe';
    }
}
