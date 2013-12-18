<?php

namespace Kub\NotificationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NotificationController extends Controller
{
	public function showAction(){

		$request = $this->get('request') ;
		$offset = (int) $request->request->get('offset'); 

		$notifications = $this->get('kub.notification_manager')->getNotifications($offset);
		$template = "show" ;

		if($request->attributes->get('_route') != 'kub_notification_show' || $request->isXmlHttpRequest() )
		{
			$template .= '_content' ;
		}
		
		return $this->render('KubNotificationBundle:Show:' . $template . '.html.twig', array(

			'notifications' => $notifications

		));

	}
}
