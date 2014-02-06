<?php

namespace Kub\CollaborationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Tache
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Kub\CollaborationBundle\Entity\TacheRepository")
 */
class Tache
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
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=255)
	 * @Assert\NotNull()
	 * @Assert\Length(min=2, max=255)
	 */
	private $name;

	/**
	 * @ORM\Column(name="slug", type="string", length=255)
	 * @Gedmo\Slug(fields={"name"})
	 */
	private $slug ;

	/**
	 * @ORM\Column(name="done", type="boolean")
	 */
	private $done;

	/**
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    /**
     * @ORM\ManyToOne(targetEntity="Kub\CollaborationBundle\Entity\ListeTaches", inversedBy="taches", cascade={"persist", "merge"})
     */
    private $listeTaches ;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="echeance", type="date")
	 */
	private $echeance;

	/**
	 * @ORM\ManyToMany(targetEntity="Kub\UserBundle\Entity\User", cascade={"persist"})
	 */
	private $participants ;

    /**
     * @ORM\OneToMany(targetEntity="Kub\CollaborationBundle\Entity\Fichier", cascade={"all"}, mappedBy="tache")
     */
    private $fichiers ;

    /**
     * @ORM\OneToMany(targetEntity="Kub\CollaborationBundle\Entity\Ressource", cascade={"all"}, mappedBy="tache")
     */
    private $ressources ;

    public function getParticipantsAsString($user = null)
	{
		$string = 'avec ';
		$users = $this->getParticipants();
		$id = $user != null ? $user->getId() : 0 ;

		$limit = 4 ;
		$limit = $limit < count($users) ? $limit : count($users) ;

		for($i = 0 ; $i < $limit ; $i++) {

			$id == $users[$i]->getId() ? $string .= 'vous ' : $string .= $users[$i] . ' ';

			if($i == $limit-2)
			{
				$string .= " et ";
			}
		}

		if(count($users) > $limit)
		{
			$string .= '...' ;
		}
		elseif(count($users) == 0)
		{
			$string = "aucun particpant pour l'instant";
		}

		return $string ;
	}

	public function __toString()
	{
		return $this->getName();
	}

	public function __construct()
	{
		$this->echeance = (new \DateTime())->modify('+1 month');

		$this->rang = 1 ;
		$this->done = false ;

		$this->participants = new \Doctrine\Common\Collections\ArrayCollection();
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
	 * Set echeance
	 *
	 * @param \DateTime $echeance
	 * @return Tache
	 */
	public function setEcheance($echeance)
	{
		$this->echeance = $echeance;
	
		return $this;
	}

	/**
	 * Get echeance
	 *
	 * @return \DateTime 
	 */
	public function getEcheance()
	{
		return $this->echeance;
	}

	/**
	 * Set organisateur
	 *
	 * @param \Kub\CollaborationBundle\Entity\Organisateur $organisateur
	 * @return Tache
	 */
	public function setOrganisateur(\Kub\CollaborationBundle\Entity\Organisateur $organisateur = null)
	{
		$this->organisateur = $organisateur;
	
		return $this;
	}

	/**
	 * Get organisateur
	 *
	 * @return \Kub\CollaborationBundle\Entity\Organisateur 
	 */
	public function getOrganisateur()
	{
		return $this->organisateur;
	}
	
	/**
	 * Add participants
	 *
	 * @param \Kub\UserBundle\Entity\User $participants
	 * @return Tache
	 */
	public function addParticipant(\Kub\UserBundle\Entity\User $participants)
	{
		if(!$this->participants->contains($participants))
		{
			$this->participants[] = $participants;
		}
	
		return $this;
	}

	/**
	 * Remove participants
	 *
	 * @param \Kub\UserBundle\Entity\User $participants
	 */
	public function removeParticipant(\Kub\UserBundle\Entity\User $participants)
	{
		$this->participants->removeElement($participants);
	}

	/**
	 * Get participants
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getParticipants()
	{
		return $this->participants;
	}

	/**
	 * Set name
	 *
	 * @param string $name
	 * @return Tache
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

    /**
     * Set rang
     *
     * @param integer $rang
     * @return Tache
     */
    public function setRang($rang)
    {
        $this->rang = $rang;
    
        return $this;
    }

    /**
     * Get rang
     *
     * @return integer 
     */
    public function getRang()
    {
        return $this->rang;
    }

    /**
     * Set listeTaches
     *
     * @param \Kub\CollaborationBundle\Entity\ListeTaches $listeTaches
     * @return Tache
     */
    public function setListeTaches(\Kub\CollaborationBundle\Entity\ListeTaches $listeTaches = null)
    {
        $this->listeTaches = $listeTaches;
    
        return $this;
    }

    /**
     * Get listeTaches
     *
     * @return \Kub\CollaborationBundle\Entity\ListeTaches 
     */
    public function getListeTaches()
    {
        return $this->listeTaches;
    }

    /**
     * Set done
     *
     * @param boolean $done
     * @return Tache
     */
    public function setDone($done)
    {
        $this->done = $done;
    
        return $this;
    }

    /**
     * Get done
     *
     * @return boolean 
     */
    public function getDone()
    {
        return $this->done;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Tache
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add fichiers
     *
     * @param \Kub\CollaborationBundle\Entity\Fichier $fichiers
     * @return Tache
     */
    public function addFichier(\Kub\CollaborationBundle\Entity\Fichier $fichiers)
    {
        $this->fichiers[] = $fichiers;
    
        return $this;
    }

    /**
     * Remove fichiers
     *
     * @param \Kub\CollaborationBundle\Entity\Fichier $fichiers
     */
    public function removeFichier(\Kub\CollaborationBundle\Entity\Fichier $fichiers)
    {
        $this->fichiers->removeElement($fichiers);
    }

    /**
     * Get fichiers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFichiers()
    {
        return $this->fichiers;
    }

    /**
     * Add ressources
     *
     * @param \Kub\CollaborationBundle\Entity\Ressource $ressources
     * @return Tache
     */
    public function addRessource(\Kub\CollaborationBundle\Entity\Ressource $ressources)
    {
        $this->ressources[] = $ressources;
    
        return $this;
    }

    /**
     * Remove ressources
     *
     * @param \Kub\CollaborationBundle\Entity\Ressource $ressources
     */
    public function removeRessource(\Kub\CollaborationBundle\Entity\Ressource $ressources)
    {
        $this->ressources->removeElement($ressources);
    }

    /**
     * Get ressources
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRessources()
    {
        return $this->ressources;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return Tache
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    
        return $this;
    }

    /**
     * Get notes
     *
     * @return string 
     */
    public function getNotes()
    {
        return $this->notes;
    }
}