<?php

namespace Kub\NotificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArianeCommentaireNotification
 * @ORM\Entity
 */
class ArianeCommentaireNotification extends Notification
{
    public function __construct()
    {
        parent::__construct();

        $this->route = "ariane_homepage" ;
        $this->titre = "Un commentaire à été ajouté à votre fil d'Ariane ";
    }

    public function getContenu()
    {
        return '' ;
    }

}