<?php
namespace Kub\NotificationBundle\Twig;

class NotificationExtension extends \Twig_Extension
{
    private $templating ;
    private $notifications ;

    public function __construct($templating, $notifications)
    {
        $this->templating = $templating ;
        $this->notifications = $notifications ;
    }

    public function getFunctions()
    {
        return array(
            'ShowNotifications' => new \Twig_Function_Method($this, 'ShowNotifications', array('is_safe' => array('html')))
        );
    }

    public function ShowNotifications()
    {
        $liste_notifications = $this->notifications->getNotifications();
        $response = '' ;

        foreach ($liste_notifications as $key => $notification) {
                
            $template = get_class($notification);
            $template = str_replace("Kub\NotificationBundle\Entity\\", "", $template);
            $template = str_replace("Notification", "", $template);

            $response .= $this->templating->render('KubNotificationBundle:Notification:' . $template . '.html.twig', array(
                "notification" => $notification 
            ));
        }

        return $response ;
    }

    public function getName()
    {
        return 'NotificationExtension';
    }
}