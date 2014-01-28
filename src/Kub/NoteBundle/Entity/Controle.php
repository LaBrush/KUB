<?php

namespace Kub\NoteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;

/**
 * Controle
 *
 * @ORM\Table()
 * @ORM\Entity
 *
 * @ORM\Entity(repositoryClass="Kub\NoteBundle\Entity\ControleRepository")
 */
class Controle
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
	 * @var \DateTime
	 *
	 * @ORM\Column(name="date", type="date")
	 * @Assert\Date()
	 */
	private $date;

	/**
	 * @ORM\Column(name="date_ajout", type="datetime")
	 */
	private $dateAjout ;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=255)
	 * @Assert\NotNull()
	 * @Assert\Length(
	 *	min=2,
	 *	max=255
	 *)
	 */
	private $name;

	/**
	 * @ORM\OneToMany(targetEntity="Kub\NoteBundle\Entity\Note", mappedBy="controle", cascade={"all"})
	 * @Assert\Valid()
	 */
	private $notes ;

	/**
	 * @ORM\ManyToOne(targetEntity="Kub\UserBundle\Entity\Professeur")
	 */
	private $professeur;

	/**
	 * @ORM\ManyToOne(targetEntity="Kub\EDTBundle\Entity\Cours", inversedBy="controles", cascade={"all"})
	 */
	private $cours ;

	public function __toString()
	{
		return $this->name . ' (' . $this->getCours()->getMatiere() . ')';
	}

	public function hasEleve($eleve)
	{
		foreach ($this->getNotes() as $note) {
			if($note->getEleve()->getId() == $eleve->getId()){ return true ; }
		}

		return false ;
	}

	public function getGroupes()
	{
		return $this->getCours()->getGroupes();
	}

	public function addGroupe(\Kub\ClasseBundle\Entity\Groupe $groupe = null)
	{
		foreach ($groupe->getEleves() as $eleve) {
			$note = new Note ;
			$note->setEleve( $eleve );

			$this->addNote( $note );
		}
	}

	public function __construct()
	{
		$this->date = new \DateTime ;
		$this->dateAjout = new \DateTime ;

		$this->notes = new \Doctrine\Common\Collections\ArrayCollection();
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
	 * Set date
	 *
	 * @param \DateTime $date
	 * @return Controle
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
	 * Set name
	 *
	 * @param string $name
	 * @return Controle
	 */
	public function setNom($name)
	{
		$this->name = $name;
	
		return $this;
	}

	/**
	 * Get name
	 *
	 * @return string 
	 */
	public function getNom()
	{
		return $this->name;
	}
	
	/**
	 * Add notes
	 *
	 * @param \Kub\NoteBundle\Entity\Note $notes
	 * @return Controle
	 */
	public function addNote(\Kub\NoteBundle\Entity\Note $notes)
	{
		$this->notes[] = $notes;
		$notes->setControle($this);
	
		return $this;
	}

	/**
	 * Remove notes
	 *
	 * @param \Kub\NoteBundle\Entity\Note $notes
	 */
	public function removeNote(\Kub\NoteBundle\Entity\Note $notes)
	{
		$this->notes->removeElement($notes);
		$notes->setControle();
	}

	/**
	 * Get notes
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getNotes()
	{
		return $this->notes;
	}

	/**
	 * Set professeur
	 *
	 * @param \Kub\UserBundle\Entity\Professeur $professeur
	 * @return Controle
	 */
	public function setProfesseur(\Kub\UserBundle\Entity\Professeur $professeur = null)
	{
		$this->professeur = $professeur;
	
		return $this;
	}

	/**
	 * Get professeur
	 *
	 * @return \Kub\UserBundle\Entity\Professeur 
	 */
	public function getProfesseur()
	{
		return $this->professeur;
	}

	/**
	 * Get matiere
	 *
	 * @return \Kub\EDTBundle\Entity\Matiere 
	 */
	public function getMatiere()
	{
		return $this->getCours()->getMatiere();
	}

	/**
	 * Set cours
	 *
	 * @param \Kub\EDTBundle\Entity\Cours $cours
	 * @return Controle
	 */
	public function setCours(\Kub\EDTBundle\Entity\Cours $cours = null)
	{
		$this->cours = $cours;
		$this->setProfesseur( $cours->getProfesseur() );
	
		return $this;
	}

	/**
	 * Get cours
	 *
	 * @return \Kub\EDTBundle\Entity\Cours 
	 */
	public function getCours()
	{
		return $this->cours;
	}

    /**
     * Set dateAjout
     *
     * @param \DateTime $dateAjout
     * @return Controle
     */
    public function setDateAjout($dateAjout)
    {
        $this->dateAjout = $dateAjout;
    
        return $this;
    }

    /**
     * Get dateAjout
     *
     * @return \DateTime 
     */
    public function getDateAjout()
    {
        return $this->dateAjout;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Controle
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
}