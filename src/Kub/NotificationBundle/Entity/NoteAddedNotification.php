<?php

namespace Kub\NotificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NoteAddedNotification
 * @ORM\Entity
 */
class NoteAddedNotification extends Notification
{
    
    public function init()
    {
        parent::init();

        $this->route = "kub_notes_eleve_homepage" ;
        $this->routeTitle = "Voir vos notes" ;
        $this->titre = "Vous avez une nouvelle note";
    }


    /**
     * @ORM\OneToOne(targetEntity="Kub\NoteBundle\Entity\Note")
     */
    private $note ; 

    public function __construct()
    {
        parent::__construct();
    }

    public function getContenu($scope = 'eleve')
    {
        if($scope == 'eleve')
        {
            return ($this->auteur . ' vous a ajouté la note de ' . $this->note)  ;
        }
        else
        {
            return ($this->auteur . ' a ajouté la note de ' . $this->note . ' à ' . $this->note->getEleve()) ;
        }
    }

    /**
     * Set note
     *
     * @param \Kub\NoteBundle\Entity\Note $note
     * @return NoteAddedNotification
     */
    public function setNote(\Kub\NoteBundle\Entity\Note $note = null)
    {
        $this->note = $note;
    
        return $this;
    }

    /**
     * Get note
     *
     * @return \Kub\NoteBundle\Entity\Note 
     */
    public function getNote()
    {
        return $this->note;
    }
}