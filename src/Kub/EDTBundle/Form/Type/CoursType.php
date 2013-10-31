<?php

namespace Kub\EDTBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
            ->add('debut', 'time', array(
                    'hours' => $this->timeService->getHours(),
                    'minutes' => $this->timeService->getMinutes()
                )
            )
            ->add('fin', 'time', array(
                    'hours' => $this->timeService->getHours(),
                    'minutes' => $this->timeService->getMinutes()
                )
            )
            ->add('jour', 'entity', array(
                    'empty_value' => 'Jour du cours',
                    'class' => 'Kub\EDTBundle\Entity\Jour'   
                )
            )
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
            ->add('semaines')
            ->add('frequences', 'entity', array(
                    "mapped" => false,
                    "class" => "Kub\EDTBundle\Entity\Frequence",
                    "expanded" => true,
                    "multiple" => true,
                    "label" => "Copier les semaines d'une fréquence"
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
