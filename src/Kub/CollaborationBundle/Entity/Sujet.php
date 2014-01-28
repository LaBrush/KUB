<?php

namespace Kub\CollaborationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity
 */
class Sujet
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
	 * @var integer
	 *
	 * @ORM\Column(name="rang", type="integer")
	 */
	private $rang;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=255)
	 */
	private $name;

	/**
	 * @ORM\OneToMany(targetEntity="Kub\CollaborationBundle\Entity\Post", mappedBy="sujet", cascade={"all"})
	 */
	private $posts ;

	/**
	 * @ORM\ManyToOne(targetEntity="Kub\CollaborationBundle\Entity\Communication", cascade={"persist"}, inversedBy="sujets")
	 */
	private $communication ;

	public function countCheckedTaches(){

		$c = 0 ;
		$taches = $this->getTaches();

		for ($i=0; $i < count($taches); $i++) { 
			if($taches[$i]->getDone())
			{
				$c++ ;
			}
		}

		return $c ;
	}

	public function __toString()
	{
		return $this->name ;
	}

	public function __construct()
	{
		$this->rang = 1 ;
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
	 * Set rang
	 *
	 * @param integer $rang
	 * @return ListeTaches
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
	 * Add taches
	 *
	 * @param \Kub\CollaborationBundle\Entity\Tache $taches
	 * @return ListeTaches
	 */
	public function addTache(\Kub\CollaborationBundle\Entity\Tache $taches)
	{
		$this->taches[] = $taches;
	
		return $this;
	}

	/**
	 * Remove taches
	 *
	 * @param \Kub\CollaborationBundle\Entity\Tache $taches
	 */
	public function removeTache(\Kub\CollaborationBundle\Entity\Tache $taches)
	{
		$this->taches->removeElement($taches);
	}

	/**
	 * Get taches
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getTaches()
	{
		return $this->taches;
	}

	/**
	 * Set organisateur
	 *
	 * @param \Kub\CollaborationBundle\Entity\Organisateur $organisateur
	 * @return ListeTaches
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
	 * Set name
	 *
	 * @param string $name
	 * @return ListeTaches
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
     * Add posts
     *
     * @param \Kub\CollaborationBundle\Entity\Post $posts
     * @return Sujet
     */
    public function addPost(\Kub\CollaborationBundle\Entity\Post $posts)
    {
        $this->posts[] = $posts;
    
        return $this;
    }

    /**
     * Remove posts
     *
     * @param \Kub\CollaborationBundle\Entity\Post $posts
     */
    public function removePost(\Kub\CollaborationBundle\Entity\Post $posts)
    {
        $this->posts->removeElement($posts);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Set communication
     *
     * @param \Kub\CollaborationBundle\Entity\Organisateur $communication
     * @return Sujet
     */
    public function setCommunication(\Kub\CollaborationBundle\Entity\Organisateur $communication = null)
    {
        $this->communication = $communication;
    
        return $this;
    }

    /**
     * Get communication
     *
     * @return \Kub\CollaborationBundle\Entity\Organisateur 
     */
    public function getCommunication()
    {
        return $this->communication;
    }
}