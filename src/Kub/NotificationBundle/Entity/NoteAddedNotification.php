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
	 * @ORM\OneToOne(targetEntity="Kub\NoteBundle\Entity\Note", cascade={"all"})
	 */
	private $contenu ; 

	public function getContenu($scope = 'eleve')
	{
		if($scope == 'eleve')
		{
			// throw new \Exception($this->note->getId());
			
			return $this->getAuteur() . ' vous a ajouté la note de ' . $this->getNote() ;
		}
		else
		{
			return $this->getAuteur() . ' a ajouté la note de ' . $this->getNote() . ' à ' . $this->note->getEleve() ;
		}
	}
}