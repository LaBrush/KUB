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
            ->add('name')
            ->add('semaines', 'entity', array(
                "multiple" => true,
                "expanded" => true,
                "class" => "Kub\EDTBundle\Entity\Semaine"
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
