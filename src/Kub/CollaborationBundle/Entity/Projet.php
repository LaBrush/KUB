<?php

namespace Kub\CollaborationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Projet
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Kub\CollaborationBundle\Entity\ProjetRepository")
 */
class Projet
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
	 * @ORM\Column(name="date_ajout", type="datetime")
	 */
	private $dateAjout;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="date_fin", type="date")
	 */
	private $dateFin;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=255)
	 */
	private $name;

	/**
	 * @ORM\Column(name="slug", type="string", length=255, unique=true)
	 * @Gedmo\Slug(fields={"name"})
	 */
	private $slug;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="description", type="text")
	 */
	private $description;

	/**
	 * @ORM\OneToOne(targetEntity="Kub\CollaborationBundle\Entity\Organisateur", cascade={"all"}, fetch="EAGER")
	 */
	private $organisateur ;

	/**
	 * @ORM\OneToOne(targetEntity="Kub\CollaborationBundle\Entity\Documentheque", cascade={"all"}, fetch="EAGER")
	 */
	private $documentheque ;

	/**
	 * @ORM\OneToMany(targetEntity="Kub\CollaborationBundle\Entity\Permission", mappedBy="projet", cascade={"all"}, fetch="EAGER")
	 */
	private $permissions ;

	public function getUsersAsString()
	{
		$string = 'avec ';
		$users = $this->getUsers();
		$i ;

		$limit = 0 ;
		$limit = $limit < count($users)-1 ? $limit : count($users)-1 ;

		for($i = 0 ; $i < $limit-1 ; $i++) {

			$string .= $users[$i] . ' ';
			
		}

		if($limit > 1)
		{
			$string .= " et ";   
			
		}

		$string .= $users[$i];

		if(count($users)-1 > $limit)
		{
			$string .= '...' ;
		}

		return $string ;
	}

	public function __toString(){
		$string = $this->name . $this->getUsersAsString();        

		return $string ;
	}

	public function __construct(){

		$this->permissions = new \Doctrine\Common\Collections\ArrayCollection();

		$this->organisateur = new Organisateur ;
		$this->documentheque = new Documentheque ;

		$this->dateAjout = new \DateTime();
		$this->dateFin = (new \DateTime())->modify('+1 month');
	}

	public function getUsers()
	{
		$users = array();

		foreach ($this->getPermissions() as $permission) {
			$users[] = $permission->getUser();
		}

		return $users ;
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
	 * Set dateAjout
	 *
	 * @param \DateTime $dateAjout
	 * @return Projet
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
	 * Set dateFin
	 *
	 * @param \DateTime $dateFin
	 * @return Projet
	 */
	public function setDateFin($dateFin)
	{
		$this->dateFin = $dateFin;
	
		return $this;
	}

	/**
	 * Get dateFin
	 *
	 * @return \DateTime 
	 */
	public function getDateFin()
	{
		return $this->dateFin;
	}

	/**
	 * Set nom
	 *
	 * @param string $nom
	 * @return Projet
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
	 * Set description
	 *
	 * @param string $description
	 * @return Projet
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	
		return $this;
	}

	/**
	 * Get description
	 *
	 * @return string 
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * Set organisateur
	 *
	 * @param \Kub\CollaborationBundle\Entity\Organisateur $organisateur
	 * @return Projet
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
	 * Set documentheque
	 *
	 * @param \Kub\CollaborationBundle\Entity\Documentheque $documentheque
	 * @return Projet
	 */
	public function setDocumentheque(\Kub\CollaborationBundle\Entity\Documentheque $documentheque = null)
	{
		$this->documentheque = $documentheque;
	
		return $this;
	}

	/**
	 * Get documentheque
	 *
	 * @return \Kub\CollaborationBundle\Entity\Documentheque 
	 */
	public function getDocumentheque()
	{
		return $this->documentheque;
	}
	
	/**
	 * Set name
	 *
	 * @param string $name
	 * @return Projet
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
	 * Add permissions
	 *
	 * @param \Kub\CollaborationBundle\Entity\Permission $permissions
	 * @return Projet
	 */
	public function addPermission(\Kub\CollaborationBundle\Entity\Permission $permissions)
	{
		$this->permissions[] = $permissions;
		$permissions->setProjet($this);
	
		return $this;
	}

	/**
	 * Remove permissions
	 *
	 * @param \Kub\CollaborationBundle\Entity\Permission $permissions
	 */
	public function removePermission(\Kub\CollaborationBundle\Entity\Permission $permissions)
	{
		$this->permissions->removeElement($permissions);
		$permissions->setProjet();
	}

	/**
	 * Get permissions
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getPermissions()
	{
		return $this->permissions;
	}

	/**
	 * Set slug
	 *
	 * @param string $slug
	 * @return Projet
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
}