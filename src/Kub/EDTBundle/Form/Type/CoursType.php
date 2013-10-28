<?php

namespace Kub\EDTBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CoursType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $hours = array();
        for ($i=7; $i <= 17 ; $i++) { 
            $hours[] = $i ;
        }

        $minutes = array();
        $minutes[] = 0 ;
        $minutes[] = 5 ;
        $minutes[] = 20;
        $minutes[] = 25;
        $minutes[] = 50;
        $minutes[] = 55;

        $builder
            ->add('debut', 'time', array(
                    "hours" => $hours,
                    "minutes" => $minutes
                )
            )
            ->add('fin', 'time', array(
                    "hours" => $hours,
                    "minutes" => $minutes
                )
            )
            ->add('professeur', "entity", array(
                    'empty_value' => 'Choisissez un professeur',
                    'class' => "Kub\UserBundle\Entity\Professeur"
                )
            )
            ->add('groupes', "entity", array(
                    "multiple" => true,
                    "expanded" => true,
                    "class" => "Kub\ClasseBundle\Entity\Groupe"
                )
            )
            ->add('matiere', "entity", array(
                    'empty_value' => 'Choisissez une matière',
                    'class' => "Kub\EDTBundle\Entity\Matiere"
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
