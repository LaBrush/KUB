<?php

namespace Kub\NotificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArianeCommentaireNotification
 * @ORM\Entity
 */
class ArianePostNotification extends Notification
{
    
    public function init()
    {
        parent::init();

        $this->route = "ariane_homepage" ;
        $this->routeTitle = "Voir le fil" ;
        $this->titre = $this->getAuteur() . ' a ajouté une trace à son fil d\'Ariane' ;;
    }


    /**
     * @ORM\OneToOne(targetEntity="Kub\ArianeBundle\Entity\Commentaire")
     */
    private $contenu ; 

    public function __construct()
    {
        parent::__construct();
    }

    public function getContenu()
    {
        return "";
    }
}