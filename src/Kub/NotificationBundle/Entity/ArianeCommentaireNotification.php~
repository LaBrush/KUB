<?php

namespace Kub\NotificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArianeCommentaireNotification
 * @ORM\Entity
 */
class ArianeCommentaireNotification extends Notification
{
    
    public function init()
    {
        parent::init();

        $this->route = "ariane_homepage" ;
        $this->routeTitle = "Voir votre fil" ;
        $this->titre = "Un commentaire à été ajouté à votre fil d'Ariane ";
    }

    public function __construct()
    {
        parent::__construct();
    }

    public function getContenu()
    {
        return '' ;
    }

}