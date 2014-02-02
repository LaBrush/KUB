<?php

namespace Kub\NotificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class NewRessourceNotification extends Notification
{
    
    public function init()
    {
        parent::init();

        $this->route = "kub_ressource_homepage" ;
        $this->routeTitle = "Voir les ressources" ;
        $this->titre = 'Ressources' ;
        $this->type = "ressources-professeur" ;
        $this->class = 'NewRessourceNotification';
    }


    /**
     * @ORM\OneToOne(targetEntity="Kub\RessourceBundle\Entity\Ressource", mappedBy="notification", cascade={"all"})
     */
    private $ressource ; 

    public function format($scope = "eleve")
    {
        return $this->getRessource()->getDescription();
    }

    /**
     * Set ressource
     *
     * @param \Kub\RessourceBundle\Entity\Ressource $ressource
     * @return NewRessourceNotification
     */
    public function setRessource(\Kub\RessourceBundle\Entity\Ressource $ressource = null)
    {
        $this->ressource = $ressource;
        $ressource->setNotification($this);

        return $this;
    }

    /**
     * Get ressource
     *
     * @return \Kub\RessourceBundle\Entity\Ressource 
     */
    public function getRessource()
    {
        return $this->ressource;
    }
}