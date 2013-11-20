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


    /**
     * @ORM\OneToOne(targetEntity="Kub\ArianeBundle\Entity\Commentaire")
     */
    private $commentaire ; 

    public function __construct()
    {
        parent::__construct();
    }

    public function getContenu()
    {
        return $this->getAuteur() . ' a dit ' . $this->commentaire->getContenu() ;
    }


    /**
     * Set commentaire
     *
     * @param \Kub\ArianeBundle\Entity\Commentaire $commentaire
     * @return ArianeCommentaireNotification
     */
    public function setCommentaire(\Kub\ArianeBundle\Entity\Commentaire $commentaire = null)
    {
        $this->commentaire = $commentaire;
    
        return $this;
    }

    /**
     * Get commentaire
     *
     * @return \Kub\ArianeBundle\Entity\Commentaire 
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }
}