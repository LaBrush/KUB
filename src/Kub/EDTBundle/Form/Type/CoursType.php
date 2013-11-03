<?php

namespace Kub\EDTBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Kub\EDTBundle\Form\Type\HoraireType ;

class CoursType extends AbstractType
{
    private $timeService ; 

    public function __construct($timeService)
    {
        $this->timeService = $timeService ;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('professeur', 'entity', array(
                    'empty_value' => 'Choisissez un professeur',
                    'class' => 'Kub\UserBundle\Entity\Professeur'
                )
            )
            ->add('groupes', 'entity', array(
                    'multiple' => true,
                    'expanded' => true,
                    'class' => 'Kub\ClasseBundle\Entity\Groupe'
                )
            )
            ->add('matiere', 'entity', array(
                    'empty_value' => 'Choisissez une matière',
                    'class' => 'Kub\EDTBundle\Entity\Matiere'
                )
            )
            ->add('horaires', 'collection', array(

                    'type' => new HoraireType($this->timeService),
                    'allow_add' => true,
                    'allow_delete' => true

                )
            )
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kub\EDTBundle\Entity\Cours'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'kub_edtbundle_cours';
    }
}
