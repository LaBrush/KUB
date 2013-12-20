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
        $eleve = $this->get('doctrine.orm.entity_manager')->getRepository('KubUserBundle:Eleve')->findByUsernameWithNotes( $this->getUser()->getUsername() );

        return $this->render("KubNoteBundle:Eleve:index.html.twig", array(
        	"eleve" => $eleve
        ));
    }
}
