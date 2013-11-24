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
        $liste_notes = $this->get('doctrine.orm.entity_manager')->getRepository('KubNoteBundle:Note')->findByEleve( $this->getUser() );

        return $this->render("KubNoteBundle:Eleve:index.html.twig", array(
        	"notes" => $liste_notes
        ));
    }
}
