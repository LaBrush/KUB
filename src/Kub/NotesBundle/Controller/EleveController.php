<?php

namespace Kub\NotesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

class EleveController extends Controller
{
    /**
     * @Secure(roles="ROLE_ELEVE")
     */
    public function indexAction()
    {
        $liste_notes = $this->get('doctrine.orm.entity_manager')->getRepository('KubNotesBundle:Note')->findByEleve( $this->getUser() );

        return $this->render("KubNotesBundle:Eleve:index.html.twig", array(
        	"notes" => $liste_notes
        ));
    }
}
