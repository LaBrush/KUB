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
		$this->titre = "Notes";
		$this->type = "bigbro" ;
		$this->class = 'NoteAddedNotification';
	}


	/**
	 * @ORM\OneToOne(targetEntity="Kub\NoteBundle\Entity\Note", mappedBy="notification")
	 */
	private $note ;

	public function format($scope = 'eleve')
	{
		if($scope == 'eleve')
		{
			return $this->getAuteur() . ' vous a ajouté la note de ' . (string)$this->getNote() ;
		}
		else
		{
			return $this->getAuteur() . ' a ajouté la note de ' . (string)$this->getNote() . ' à ' . $this->getNote()->getEleve() ;
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
        $note->setNotification($this);
    
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