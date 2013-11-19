<?php

namespace Kub\ArianeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException ;

use Kub\ArianeBundle\Entity\Post ;
use Kub\ArianeBundle\Entity\Fil  ;

class DefaultController extends Controller
{
    public function indexAction($username)
    {
        switch($this->getUser()->getClass())
        {
            case 'eleve':
                return $this->showEleveAction();
                break ;
            case 'professeur':
                return $this->showProfesseurAction($username);
                break ;
            default:
                throw new AccessDeniedException("Vous n'avez pas accès aux fils d'ariane");
        }
    }

    public function showEleveAction()
    {
        $security = $this->get('security.context');
        $liste_posts = $this->getDoctrine()->getManager()->getRepository('KubArianeBundle:Post')->findByUser( $this->getUser()->getUsername() );

        return $this->render('KubArianeBundle:Eleve:home.html.twig', array(
            'liste_posts' => $liste_posts,
            'fil' => $this->getUser()->getFil()
        ));
    }

    public function showProfesseurAction($username)
    {
    	$liste_posts = $this->getDoctrine()->getManager()->getRepository('KubArianeBundle:Post')->findByUser($username);

    	return $this->render('KubArianeBundle:Eleve:home.html.twig', array(
            'liste_posts' => $liste_posts
        ));
    }
}
