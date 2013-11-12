<?php

namespace Kub\ClasseBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Kub\UserBundle\Entity\EleveRepository ;

class addMemberFieldSuscriber implements EventSubscriberInterface
{

    private $data ;
    private $form ;

    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    public function preSetData(FormEvent $event)
    {
        $this->data = $event->getData();
        $this->form = $event->getForm();

        if ($this->data->getId()) {
            $this->form->add('eleves_entity', 'entity', array(
                'class' => 'Kub\UserBundle\Entity\Eleve',
                "multiple" => true,
                "expanded" => true,
                "property_path" => "eleves",
                'query_builder' => function(EleveRepository $er) {

                    return $er->createQueryBuilder('e')
                        ->orderBy('e.username', 'ASC')
                        ->where('e.niveau = :niveau')
                        ->setParameter('niveau', $this->data->getNiveau())
                    ;
                }
            ));

            $this->form->add('eleves', 'genemu_jqueryselect2_entity', array(
                'class' => 'Kub\UserBundle\Entity\Eleve',
                "multiple" => true,
                "expanded" => true,
                'query_builder' => function(EleveRepository $er) {

                    return $er->createQueryBuilder('e')
                        ->orderBy('e.username', 'ASC')
                        ->where('e.niveau = :niveau')
                        ->setParameter('niveau', $this->data->getNiveau())
                    ;
                }
            ));
        }
    }
}