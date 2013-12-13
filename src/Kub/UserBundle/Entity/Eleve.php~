<?php

namespace Kub\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;
use Kub\UserBundle\Entity\Photo;

/**
 * Eleve
 *
 * @ORM\Entity
 * @ORM\Table()
 *
 * @ORM\Entity(repositoryClass="Kub\UserBundle\Entity\EleveRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Eleve extends User 
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="anniversaire", type="date")
	 *
	 * @Assert\Date()
	 * @Assert\NotBlank()
	 */
	private $anniversaire;

	/**
	 * @ORM\ManyToMany(targetEntity="Kub\UserBundle\Entity\Tuteur", inversedBy="eleves", cascade={"merge", "detach", "persist"})
	 * @Assert\Valid()
	 * @Assert\Count(max=2, maxMessage="L'élève ne peut avoir plus de deux tuteurs")
	 */
	private $tuteurs ;

	/**
	 * @ORM\ManyToOne(targetEntity="Kub\ClasseBundle\Entity\Niveau", inversedBy="eleves"))
	 */
	private $niveau ;

	/**
	 * @ORM\ManyToMany(targetEntity="Kub\ClasseBundle\Entity\Groupe", mappedBy="eleves", cascade={"merge", "detach", "persist"})
	 */
	protected $groupes;

	/**
	 * @ORM\OneToOne(targetEntity="Kub\ArianeBundle\Entity\Fil", inversedBy="eleve", cascade={"persist", "remove"})
	 */
	private $fil ;

	/**
	 * @ORM\OneToOne(targetEntity="Kub\UserBundle\Entity\Photo", cascade={"all"})
	 */
	private $photo;

	public function initClass()
	{
		$this->class = "eleve";
	}

	public function __construct()
	{
		parent::__construct();

		$this->addRole("ROLE_ELEVE");

		$this->setfil(new \Kub\ArianeBundle\Entity\Fil) ;
		$this->tuteurs = new \Doctrine\Common\Collections\ArrayCollection;
		$this->groupes = new \Doctrine\Common\Collections\ArrayCollection;
	}

	public function getProfesseurs()
	{
		$professeurs = array();

		foreach ($this->getGroupes() as $groupe) {
			foreach ($groupe->getCours() as $cours) {
				$professeur = $cours->getProfesseur();
				if(!in_array($professeur, $professeurs))
				{
					$professeurs[] = $professeur ;
				}
			}
		}

		return $professeurs ;
	}

	/**
	 * @Assert\True(message="L'élève doit avoir un niveau")
	 */
	public function isNiveauHaving()
	{
		if($this->niveau != null)
		{
			return true ;
		}
		else
		{
			return false; 
		}
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
	 * Set anniversaire
	 *
	 * @param \DateTime $anniversaire
	 * @return Eleve
	 */
	public function setAnniversaire($anniversaire)
	{
		$this->anniversaire = $anniversaire;
	
		return $this;
	}

	/**
	 * Get anniversaire
	 *
	 * @return \DateTime 
	 */
	public function getAnniversaire()
	{
		return $this->anniversaire;
	}

	/**
	 * Add tuteurs
	 *
	 * @param \Kub\UserBundle\Entity\Tuteur $tuteurs
	 * @return Eleve
	 */
	public function addTuteur(\Kub\UserBundle\Entity\Tuteur $tuteurs)
	{
		$this->tuteurs[] = $tuteurs;
	
		return $this;
	}

	/**
	 * Remove tuteurs
	 *
	 * @param \Kub\UserBundle\Entity\Tuteur $tuteurs
	 */
	public function removeTuteur(\Kub\UserBundle\Entity\Tuteur $tuteurs)
	{
		$this->tuteurs->removeElement($tuteurs);
	}

	/**
	 * Get tuteurs
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getTuteurs()
	{
		return $this->tuteurs;
	}

	/**
	 * Set niveau
	 *
	 * @param \Kub\ClasseBundle\Entity\Niveau $niveau
	 * @return Eleve
	 */
	public function setNiveau(\Kub\ClasseBundle\Entity\Niveau $niveau = null)
	{
		$this->niveau = $niveau;
	
		return $this;
	}

	/**
	 * Get niveau
	 *
	 * @return \Kub\ClasseBundle\Entity\Niveau 
	 */
	public function getNiveau()
	{
		return $this->niveau;
	}

	/**
	 * Add groupes
	 *
	 * @param \Kub\ClasseBundle\Entity\Groupe $groupes
	 * @return Eleve
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
	 * Set fil
	 *
	 * @param \Kub\ArianeBundle\Entity\Fil $fil
	 * @return Eleve
	 */
	public function setFil(\Kub\ArianeBundle\Entity\Fil $fil = null)
	{
		$this->fil = $fil;
	
		return $this;
	}

	/**
	 * Get fil
	 *
	 * @return \Kub\ArianeBundle\Entity\Fil 
	 */
	public function getFil()
	{
		return $this->fil;
	}

	/**
	 * Set photo
	 *
	 * @param \Kub\UserBundle\Entity\Photo $photo
	 * @return Eleve
	 */
	public function setPhoto(\Kub\UserBundle\Entity\Photo $photo = null)
	{
		$this->photo = $photo;
	
		return $this;
	}

	/**
	 * Get photo
	 *
	 * @return \Kub\UserBundle\Entity\Photo 
	 */
	public function getPhoto()
	{
		if($this->photo)
		{
			return $this->photo  ;
		}

		return new Photo ;
	}
}