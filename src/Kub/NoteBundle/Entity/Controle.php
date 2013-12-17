<?php

namespace Kub\NoteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;

/**
 * Controle
 *
 * @ORM\Table()
 * @ORM\Entity
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
	 * @ORM\Column(name="date", type="datetime")
	 */
	private $date;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="nom", type="string", length=255)
	 * @Assert\NotNull()
	 */
	private $nom;

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
	 * @ORM\ManyToOne(targetEntity="Kub\EDTBundle\Entity\Matiere")
	 */
	private $matiere;  

	/**
	 * @ORM\ManyToOne(targetEntity="Kub\EDTBundle\Entity\Cours", inversedBy="controles", cascade={"all"})
	 */
	private $cours ;

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
	 * Set nom
	 *
	 * @param string $nom
	 * @return Controle
	 */
	public function setNom($nom)
	{
		$this->nom = $nom;
	
		return $this;
	}

	/**
	 * Get nom
	 *
	 * @return string 
	 */
	public function getNom()
	{
		return $this->nom;
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
     * Set matiere
     *
     * @param \Kub\EDTBundle\Entity\Matiere $matiere
     * @return Controle
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
     * Set cours
     *
     * @param \Kub\EDTBundle\Entity\Cours $cours
     * @return Controle
     */
    public function setCours(\Kub\EDTBundle\Entity\Cours $cours = null)
    {
        $this->cours = $cours;
        $this->setMatiere( $cours->getMatiere() );
    
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
}