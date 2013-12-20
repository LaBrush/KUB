<?php

namespace Kub\NoteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

class EleveController extends Controller
{
    /**
     * @Secure(roles="ROLE_ELEVE")
     */
    public function indexAction()
    {
        $user = $this->getUser();

        $notes = $this->get('doctrine.orm.entity_manager')->getRepository('KubNoteBundle:Note')->findByUsername( $user->getUsername() );
        $moyennes = $this->get('doctrine.orm.entity_manager')->getRepository('KubNoteBundle:Note')->findMoyennesFor( $user->getUsername() );

        $matieres = array();

        for ($i=0; $i < count($notes) ; $i++) { 
            if(!isset($matieres[ $notes[$i]['matiere'] ])) {
                $matieres[ $notes[$i]['matiere'] ] = array();   
            }

            $matieres[ $notes[$i]['matiere'] ][] = $notes[$i]['note'] ;
        }                       

        return $this->render('KubNoteBundle:Professeur:show_eleve.html.twig',
            array(
                'matieres' => $matieres,
                'moyennes' => $moyennes,
                'eleve' => $user
            )
        ); 
    }
}
