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

        $this->routeTitle = "Voir le fil" ;
        $this->titre = $this->getAuteur() . ' a ajouté une trace à son fil d\'Ariane' ;
        $this->type = "ariane-post" ;
    }


    

    /**
     * @ORM\OneToOne(targetEntity="Kub\ArianeBundle\Entity\Post", mappedBy="notification")
     */
    private $post ; 

    public function format($scope)
    {
        return $this->getPost()->getContenu();
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