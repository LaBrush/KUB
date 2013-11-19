<?php

namespace Kub\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $security = $this->get('security.context');

        $this->get('kub.notification_manager')->addNotification('ArianeCommentaireNotification');

    	if($security->isGranted("ROLE_USER"))
    	{
    		return $this->render("KubHomeBundle:User:index.html.twig");
    	}
    	else
    	{
    		return $this->render("KubHomeBundle:Visiteur:index.html.twig");
    	}

    }
}
