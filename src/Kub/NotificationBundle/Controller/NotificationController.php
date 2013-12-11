<?php

namespace Kub\NotificationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NotificationController extends Controller
{
    public function showAction(){

        $request = $this->get('request') ;
        $offset = (int) $request->request->get('username'); 

        $notifications = $this->getNotifications($offset);

        if($request->attributes->get('_route') != 'kub_notification_show' || $this->isXmlHttpRequest() )
        {
            return $notifications ;
        }

        $this->render('KubNotificationBundle:Show:show.html.twig', array(

            'notifications' => $notifications

        ));

    }

    public function getNotifications($offset)
    {
        $liste_notifications = $this->get('kub.notification_manager')->getNotifications($offset);
        $response = '' ;

        foreach ($liste_notifications as $key => $notification) {
                
            $template = get_class($notification);
            $template = str_replace("Kub\NotificationBundle\Entity\\", "", $template);
            $template = str_replace("Notification", "", $template);

            $response .= $this->render('KubNotificationBundle:Notification:' . $template . '.html.twig', array(
                "notification" => $notification 
            ));
        }

        if(count($liste_notifications) == 0)
        {
            $response = $this->render('KubNotificationBundle:Notification:no_notification.html.twig');
        }

        return $response ;
    }
}
