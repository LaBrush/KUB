<?php

namespace Kub\NoteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;

/**
 * Note
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Kub\NoteBundle\Entity\NoteRepository")
 */
class Note
{
    private $noter ;

    public function getNoter()
    {
        return $this->noter ;
    }

    public function setNoter($noter)
    {
        $this->noter = $noter ;
    }

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;  

	/**
	 * @ORM\ManyToOne(targetEntity="Kub\UserBundle\Entity\Eleve", inversedBy="notes", cascade={"merge", "detach", "persist"})
	 */
	private $eleve;

	/**
     * @ORM\ManyToOne(targetEntity="Kub\NoteBundle\Entity\Controle", inversedBy="notes")
     */
    private $controle ;

	/**
	 * @var double
	 *
	 * @ORM\Column(name="note", type="decimal", precision=4, scale=2)
	 *
     * @Assert\GreaterThanOrEqual(0, message="Vous ne pouvez attribuer de note négative")
	 */
	private $note ;

	/**
	 * @var double
	 *
	 * @ORM\Column(name="coefficient", type="decimal", precision=4, scale=2)
	 *
     * @Assert\GreaterThan(0, message="Une note ne peut avoir de coefficient nul")
	 */
	private $coefficient;

    /**
     * @ORM\OneToOne(targetEntity="Kub\NotificationBundle\Entity\NoteAddedNotification", inversedBy="note",  cascade={"all"})
     */
    private $notification ;

	public function __construct()
	{
        $this->noter = false ;
	}

	public function __toString()
	{
		return $this->note . ' / ' . $this->coefficient ;
	}

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set note
     *
     * @param float $note
     * @return Note
     */
    public function setNote($note)
    {
        $this->note = $note;
    
        return $this;
    }

    /**
     * Get note
     *
     * @return float 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set coefficient
     *
     * @param float $coefficient
     * @return Note
     */
    public function setCoefficient($coefficient)
    {
        $this->coefficient = $coefficient;
    
        return $this;
    }

    /**
     * Get coefficient
     *
     * @return float 
     */
    public function getCoefficient()
    {
        return $this->coefficient;
    }

    /**
     * Set eleve
     *
     * @param \Kub\UserBundle\Entity\Eleve $eleve
     * @return Note
     */
    public function setEleve(\Kub\UserBundle\Entity\Eleve $eleve = null)
    {
        $this->eleve = $eleve;
    
        return $this;
    }

    /**
     * Get eleve
     *
     * @return \Kub\UserBundle\Entity\Eleve 
     */
    public function getEleve()
    {
        return $this->eleve;
    }

    /**
     * Add controle
     *
     * @param \Kub\NoteBundle\Entity\Controle $controle
     * @return Note
     */
    public function addControle(\Kub\NoteBundle\Entity\Controle $controle)
    {
        $this->controle[] = $controle;
    
        return $this;
    }

    /**
     * Remove controle
     *
     * @param \Kub\NoteBundle\Entity\Controle $controle
     */
    public function removeControle(\Kub\NoteBundle\Entity\Controle $controle)
    {
        $this->controle->removeElement($controle);
    }

    /**
     * Get controle
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getControle()
    {
        return $this->controle;
    }

    /**
     * Set controle
     *
     * @param \Kub\NoteBundle\Entity\Controle $controle
     * @return Note
     */
    public function setControle(\Kub\NoteBundle\Entity\Controle $controle = null)
    {
        $this->controle = $controle;
    
        return $this;
    }

    /**
     * Set notification
     *
     * @param \Kub\NotificationBundle\Entity\NoteAddedNotification $notification
     * @return Note
     */
    public function setNotification(\Kub\NotificationBundle\Entity\NoteAddedNotification $notification = null)
    {
        $this->notification = $notification;
    
        return $this;
    }

    /**
     * Get notification
     *
     * @return \Kub\NotificationBundle\Entity\NoteAddedNotification 
     */
    public function getNotification()
    {
        return $this->notification;
    }
}