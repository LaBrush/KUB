<?php

namespace Kub\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;

/**
 * Eleve
 *
 * @ORM\Entity
 * @ORM\Table()
 *
 * @ORM\Entity(repositoryClass="Kub\UserBundle\Entity\EleveRepository")
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
	 *  @ORM\ManyToMany(targetEntity="Kub\UserBundle\Entity\Tuteur", inversedBy="eleves", cascade={"persist"})
	 * @Assert\Valid()
	 */
	private $tuteurs ;

	/**
	 * @ORM\ManyToOne(targetEntity="Kub\ClasseBundle\Entity\Niveau", inversedBy="eleves"))
	 */
	private $niveau ;

	/**
	 * @ORM\ManyToMany(targetEntity="Kub\ClasseBundle\Entity\Groupe", mappedBy="eleves")
	 */
	protected $groupes;

	/**
	 * @ORM\OneToOne(targetEntity="Kub\ArianeBundle\Entity\Fil")
	 */
	private $filAriane ;

	public function initClass()
	{
		$this->class = "eleve";
	}

	public function __construct()
	{
		parent::__construct();

		$this->addRole("ROLE_ELEVE");
		$this->tuteurs = new \Doctrine\Common\Collections\ArrayCollection;
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
	 *  @Assert\LessThanOrEqual(
	 *       value= 2,
	 *       message="L'élève ne peut avoir plus de deux tuteurs")
	 */
	public function getNumberOfTuteurs()
	{
		return count($this->tuteurs);
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
		$tuteurs->addEleve($this);
	
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
		$tuteurs->removeEleve($this);
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
	 * Add niveau
	 *
	 * @param \Kub\ClasseBundle\Entity\Niveau $niveau
	 * @return Eleve
	 */
	public function addNiveau(\Kub\ClasseBundle\Entity\Niveau $niveau)
	{
		$this->niveau[] = $niveau;
	
		return $this;
	}

	/**
	 * Remove niveau
	 *
	 * @param \Kub\ClasseBundle\Entity\Niveau $niveau
	 */
	public function removeNiveau(\Kub\ClasseBundle\Entity\Niveau $niveau)
	{
		$this->niveau->removeElement($niveau);
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
	 * Get niveau
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getNiveau()
	{
		return $this->niveau;
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
     * Set filAriane
     *
     * @param \Kub\ArianeBundle\Entity\Fil $filAriane
     * @return Eleve
     */
    public function setFilAriane(\Kub\ArianeBundle\Entity\Fil $filAriane = null)
    {
        $this->filAriane = $filAriane;
    
        return $this;
    }

    /**
     * Get filAriane
     *
     * @return \Kub\ArianeBundle\Entity\Fil 
     */
    public function getFilAriane()
    {
        return $this->filAriane;
    }
}