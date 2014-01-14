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
        $this->routeTitle = "Afficher votre fil" ;
        $this->titre = "Fil d'Ariane";
        $this->type = "espace-collaboratif" ;
        $this->class = 'ArianeCommentaireNotification';
    }


    /**
     * @ORM\OneToOne(targetEntity="Kub\ArianeBundle\Entity\Commentaire", mappedBy="notification")
     */
    private $commentaire ; 

    public function format($scope)
    {
        return "<strong>". $this->getAuteur() . "</strong> a commenté la trace <strong>" . $this->getTitre() . "</strong> de votre fil d'Ariane : <strong>\"" . $this->getCommentaire()->getContenu() . "\"</strong>" ;
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
        $commentaire->setNotification($this);
    
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