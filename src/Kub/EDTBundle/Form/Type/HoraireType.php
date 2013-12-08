<?php

namespace Kub\EDTBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HoraireType extends AbstractType
{
	private $timeService ; 

	public function __construct($timeService)
	{
		$this->timeService = $timeService ;
	}

<<<<<<< HEAD
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
			->add('frequences', 'entity', array(
					"mapped" => false,
					"expanded" => true,
					"multiple" => true,
					"class" => "Kub\EDTBundle\Entity\Frequence",
					"label" => "Séléctionner une fréquence de cours (ex: Semaines A)"
				)
			)
			->add('semaines')
		;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Kub\EDTBundle\Entity\Horaire'
		));
	}
=======
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
            ->add('frequences', 'entity', array(
                    "mapped" => false,
                    "class" => "Kub\EDTBundle\Entity\Frequence",
                    "expanded" => true,
                    "multiple" => true,
                    "label" => "Séléctionner une fréquence de cours",
                )
            )
            ->add('semaines', 'genemu_jqueryselect2_entity', array(
                    "class" => "Kub\EDTBundle\Entity\Semaine",
                    "mapped" => true,
                    "multiple" => true,
                    "label" => "Autres semaines",
                    'empty_value' => 'Choisissez des semaines'
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kub\EDTBundle\Entity\Horaire'
        ));
    }
>>>>>>> 23630f5172763de60022ea0df5bd651fece7c032

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'kub_edtbundle_horaire';
	}
}
