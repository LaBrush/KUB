<?php

namespace Kub\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $security = $this->get('security.context');

    	if($security->isGranted("ROLE_USER"))
    	{
            $notification = $this->get('kub.notification_manager');

            // $notification->addNotification('ArianeCommentaireNotification');
            $liste_notifications = $notification->getNotifications();

    		return $this->render("KubHomeBundle:User:index.html.twig", array(
                "liste_notifications" => $liste_notifications 
            ));
    	}
    	else
    	{
    		return $this->render("KubHomeBundle:Visiteur:index.html.twig");
    	}

    }
}
