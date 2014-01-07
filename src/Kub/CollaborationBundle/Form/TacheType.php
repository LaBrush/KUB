<?php

namespace Kub\CollaborationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TacheType extends AbstractType
{

    private $organisateur

    public function __construct($organisateur)
    {
        $this->organisateur = $organisateur ;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('echeance')
            ->add('participants')
            ->add('tache', 'entity', array(

                'choices' => $this->organisateur->getListeTaches(),
                "data_class" => "Kub\CollaborationBundle\Entity\ListeTaches"

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
