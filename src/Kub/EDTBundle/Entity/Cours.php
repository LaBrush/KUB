<?php

namespace Kub\EDTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;
use Kub\EDTBundle\Entity\Horaire ;
use Kub\EDTBundle\Validator\Constraints as KAssert ;

/**
 * Cours
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Kub\EDTBundle\Entity\CoursRepository")
 *
 * @KAssert\NoHoraireConflict(groups={"second_pass"})
 */
class Cours
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
	 * @ORM\ManyToMany(targetEntity="Kub\ClasseBundle\Entity\Groupe", inversedBy="cours", cascade={"merge", "detach", "persist"})
	 * @Assert\Count(min=1)
	 */
	private $groupes ;

	/** 
	 * @ORM\ManyToOne(targetEntity="Kub\UserBundle\Entity\Professeur", inversedBy="cours", cascade={"merge", "detach", "persist"})
	 * @Assert\NotNull()
	 */
	private $professeur ;

	/** 
	 * @ORM\ManyToOne(targetEntity="Kub\EDTBundle\Entity\Matiere", inversedBy="cours", cascade={"persist", "merge", "detach"})
	 * @Assert\NotNull()
	 */
	private $matiere ;

	/** 
	 * @ORM\OneToMany(targetEntity="Kub\EDTBundle\Entity\Horaire", mappedBy="cours", cascade={"all"})
	 * @Assert\Count(min=1, minMessage="Un cours doit avoir au moins un horaire")
	 * @Assert\Valid()
	 */
	private $horaires ;    

	/**
	 * @ORM\OneToMany(targetEntity="Kub\NoteBundle\Entity\Controle", mappedBy="cours", cascade={"persist", "merge", "detach"})
	 */
	private $controles ;

	/**
	 * @Assert\True(message="Un cours ne peut avoir d'éléves de niveau différents")
	 */
	public function isMonoLevel()
	{
		if(count($this->groupes))
		{
			$groupes = $this->groupes ;
			$niveauRef = $groupes[0]->getNiveau();

			foreach ($groupes as $key => $groupe) {
				
				if($groupe->getNiveau() != $niveauRef)
				{
					return false ;
				}

			}

			return true ;
		}

		return true ;
	}

	public function __toString()
	{
		return $this->matiere . " avec " . $this->professeur . ' et ' . $this->getGroupesAsString() ;
	}

	public function getToStringProfesseur()
	{
		return $this->matiere . " avec " . $this->getGroupesAsString() ;
	}

	public function getGroupesAsString()
	{
		$groupesNames = "" ;
		$groupes = $this->getGroupes();
		$size = count($groupes);

		for ($i=0; $i < $size ; $i++) { 
			$groupesNames .= $groupes[$i] . ' ' ;

			if($i == $size - 1 && $size > 1)
			{
				$groupesNames .= 'et ' ;
			}
		}

		return $groupesNames ;
	}

	public function getCurrentHoraire()
	{
		$current = new \DateTime();
		$horaires = $this->getHoraires();

		for ($i=0; $i < count($horaires); $i++) { 
			
			if($horaires[$i]->contains($current))
			{
				return $horaires[$i];
			}

		}

		return false ;
	}

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->groupes = new \Doctrine\Common\Collections\ArrayCollection;
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
	 * Add groupes
	 *
	 * @param \Kub\ClasseBundle\Entity\Groupe $groupes
	 * @return Cours
	 */
	public function addGroupe(\Kub\ClasseBundle\Entity\Groupe $groupes)
	{
		$this->groupes[] = $groupes;
	
		return $this;
	}

	/**
	 * Remove groupes
	 *
	 * @param \Kub\ClasseBundle\Entity\Groupe $groupes
	 */
	public function removeGroupe(\Kub\ClasseBundle\Entity\Groupe $groupes)
	{
		$this->groupes->removeElement($groupes);
	}

	/**
	 * Get groupes
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getGroupes()
	{
		return $this->groupes;
	}

	/**
	 * Set professeur
	 *
	 * @param \Kub\UserBundle\Entity\Professeur $professeur
	 * @return Cours
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
	 * @return Cours
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
	 * Add horaires
	 *
	 * @param \Kub\EDTBundle\Entity\Horaire $horaires
	 * @return Cours
	 */
	public function addHoraire(\Kub\EDTBundle\Entity\Horaire $horaires)
	{   
		$this->horaires[] = $horaires;
		$horaires->setCours($this);
	
		return $this;
	}

	/**
	 * Remove horaires
	 *
	 * @param \Kub\EDTBundle\Entity\Horaire $horaires
	 */
	public function removeHoraire(\Kub\EDTBundle\Entity\Horaire $horaires)
	{
		$this->horaires->removeElement($horaires);
		$horaires->setCours();
	}

	/**
	 * Get horaires
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getHoraires()
	{
		return $this->horaires;
	}

	/**
	 * Add professeur
	 *
	 * @param \Kub\UserBundle\Entity\Professeur $professeur
	 * @return Cours
	 */
	public function addProfesseur(\Kub\UserBundle\Entity\Professeur $professeur)
	{
		$this->professeur[] = $professeur;
	
		return $this;
	}

	/**
	 * Remove professeur
	 *
	 * @param \Kub\UserBundle\Entity\Professeur $professeur
	 */
	public function removeProfesseur(\Kub\UserBundle\Entity\Professeur $professeur)
	{
		$this->professeur->removeElement($professeur);
	}

	/**
	 * Add controles
	 *
	 * @param \Kub\NoteBundle\Entity\Controle $controles
	 * @return Cours
	 */
	public function addControle(\Kub\NoteBundle\Entity\Controle $controles)
	{
		$this->controles[] = $controles;
	
		return $this;
	}

	/**
	 * Remove controles
	 *
	 * @param \Kub\NoteBundle\Entity\Controle $controles
	 */
	public function removeControle(\Kub\NoteBundle\Entity\Controle $controles)
	{
		$this->controles->removeElement($controles);
	}

	/**
	 * Get controles
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getControles()
	{
		return $this->controles;
	}
}