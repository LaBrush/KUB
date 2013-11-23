<?php

namespace Kub\NotesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Note
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Kub\NotesBundle\Entity\NoteRepository")
 */
class Note
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Kub\EDTBundle\Entity\Matiere")
	 */
	private $matiere;    

	/**
     * @ORM\ManyToOne(targetEntity="Kub\UserBundle\Entity\Eleve")
     */
    private $eleve;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="note", type="integer")
	 */
	private $note;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="coefficient", type="integer")
	 */
	private $coefficient;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="date", type="datetime")
	 */
	private $date;

	public function __construct()
	{
		$this->date = new \DateTime ;
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
	 * @param integer $note
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
	 * @return integer 
	 */
	public function getNote()
	{
		return $this->note;
	}

	/**
	 * Set coefficient
	 *
	 * @param integer $coefficient
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
	 * @return integer 
	 */
	public function getCoefficient()
	{
		return $this->coefficient;
	}

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Note
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set matiere
     *
     * @param \Kub\EDTBundle\Entity\Matiere $matiere
     * @return Note
     */
    public function setMatiere(\Kub\EDTBundle\Entity\Matiere $matiere = null)
    {
        $this->matiere = $matiere;
    
        return $this;
    }

    /**
     * Get matiere
     *
     * @return \Kub\EDTBundle\Entity\Matiere 
     */
    public function getMatiere()
    {
        return $this->matiere;
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
}