<?php

namespace Kub\EDTBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FrequenceType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
<<<<<<< HEAD
            ->add('name')
            ->add('semaines', 'genemu_jqueryselect2_entity', array(
=======
            ->add('name', 'text', array(
                "label" => "Nom de la fréquence",

            ))
            ->add('semaines', 'entity', array(
>>>>>>> e745555f64cba50323fdead3188e06ca2823fb57
                "multiple" => true,
                "expanded" => true,
                "class" => "Kub\EDTBundle\Entity\Semaine",
                "label" => "Semaines comprises"
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kub\EDTBundle\Entity\Frequence'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'kub_edtbundle_frequence';
    }
}
