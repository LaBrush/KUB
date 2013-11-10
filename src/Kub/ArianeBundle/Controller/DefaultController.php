<?php

namespace Kub\ArianeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Kub\ArianeBundle\Entity\Post ;
use Kub\ArianeBundle\Entity\Fil  ;

class DefaultController extends Controller
{

    /**
     * @Secure(roles="ROLE_ELEVE")
     */
    public function indexAction()
    {
        $security = $this->get('security.context');
        $liste_posts = $this->getDoctrine()->getManager()->getRepository('KubArianeBundle:Post')->findByUser( $this->getUser()->getUsername() );

        return $this->render('KubArianeBundle:Eleve:home.html.twig', array(
            'liste_posts' => $liste_posts
        ));
    }

    /**
     * @Secure(roles="ROLE_PROFESSEUR")
     */
    public function showAction($username)
    {
    	$liste_posts = $this->getDoctrine()->getManager()->getRepository('KubArianeBundle:Post')->findByUser($username);

    	return $this->render('KubArianeBundle:Eleve:home.html.twig', array(
            'liste_posts' => $liste_posts
        ));
    }
}
