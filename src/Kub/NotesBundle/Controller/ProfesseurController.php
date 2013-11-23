<?php

namespace Kub\NotesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Kub\NotesBundle\Form\Type\NoteGroupeType ;

class ProfesseurController extends Controller
{
    /**
     * @Secure(roles="ROLE_PROFESSEUR")
     */
    public function indexAction($groupe)
    {
        if (null == $groupe) {
            $liste_groupes = $this->get('doctrine.orm.entity_manager')->getRepository('KubClasseBundle:Groupe')->getGroupesOfProfesseur( $this->getUser() );

            return $this->render("KubNotesBundle:Professeur:index.html.twig", array(
                "groupes" => $liste_groupes
            ));
        }
        else
        {
            $groupe = $this->get('doctrine.orm.entity_manager')->getRepository('KubClasseBundle:Groupe')->findOneByName( $groupe );
            $form  = $this->createForm(new NoteGroupeType( $groupe ));

            return $this->render("KubNotesBundle:Professeur:noter.html.twig", array(
                "form" => $form->createView()
            ));
        }
    }
}
