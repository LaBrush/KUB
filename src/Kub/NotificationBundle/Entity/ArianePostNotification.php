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

        $this->route = "ariane_homepage";
        $this->routeAttr["username"] = $this->getPost()->getFil()->getEleve()->getUsername();

        $this->routeTitle = "Afficher le fil" ;
        $this->titre = "Fil d'Ariane" ;
        $this->type = "espace-collaboratif" ;
    }


    

    /**
     * @ORM\OneToOne(targetEntity="Kub\ArianeBundle\Entity\Post", mappedBy="notification")
     */
    private $post ; 

    public function format($scope)
    {
        return "<strong>" . $this->getAuteur() . "</strong> a ajouté la trace <strong>\"" . $this->getPost()->getTitre() . "\"</strong> à son fil d'Ariane.";
    }

    /**
     * Set post
     *
     * @param \Kub\ArianeBundle\Entity\Post $post
     * @return ArianePostNotification
     */
    public function setPost(\Kub\ArianeBundle\Entity\Post $post = null)
    {
        $this->post = $post;
        $post->setNotification($this);
    
        return $this;
    }

    /**
     * Get post
     *
     * @return \Kub\ArianeBundle\Entity\Post 
     */
    public function getPost()
    {
        return $this->post;
    }
}