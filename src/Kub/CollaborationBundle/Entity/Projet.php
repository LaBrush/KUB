<?php

namespace Kub\CollaborationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\ExecutionContextInterface;

use Kub\CollaborationBundle\Entity\Permission ;

/**
 * Projet
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Kub\CollaborationBundle\Entity\ProjetRepository")
 *
 * @Assert\Callback(methods={"hasUnlessAnAdmin"})
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
	 * 
	 * @Assert\Length(
	 *	min=2,
	 *	max=255
	 * )
	 * @Assert\NotNull()
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
	 * @ORM\Column(name="description", type="text", nullable=true)
	 */
	private $description;

	/**
	 * @ORM\OneToOne(targetEntity="Kub\CollaborationBundle\Entity\Organisateur", inversedBy="projet", cascade={"all"}, fetch="EAGER")
	 */
	private $organisateur ;

	/**
	 * @ORM\OneToOne(targetEntity="Kub\CollaborationBundle\Entity\Documentheque", cascade={"all"}, fetch="EAGER")
	 */
	private $documentheque ;

	/**
	 * @ORM\OneToOne(targetEntity="Kub\CollaborationBundle\Entity\Communication", inversedBy="projet", cascade={"all"}, fetch="EAGER")
	 */
	private $communication ;

	/**
	 * @ORM\OneToMany(targetEntity="Kub\CollaborationBundle\Entity\Permission", mappedBy="projet", cascade={"all"}, fetch="EAGER")
	 */
	private $permissions ;

	public function hasUnlessAnAdmin(ExecutionContextInterface $context)
	{
		foreach ($this->getPermissions() as $permission) {
			if($permission->getRole() == Permission::ADMINISTRATEUR)
			{
				return true ;
			}
		}

		$context->addViolationAt('permissions', 'Un projet doit avoir au moins un administrateur', array(), null);
	}

	public function getUsersAsString($user = null)
	{
		$string = 'avec ';
		$users = $this->getUsers();
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

		return $string ;
	}

	public function toString($user = null){
		$string = $this->name . ' ' . $this->getUsersAsString($user);        

		return $string ;
	}

	public function __toString(){
		return (string)$this;
	}

	public function __construct(){

		$this->permissions = new \Doctrine\Common\Collections\ArrayCollection();

		$this->organisateur = new Organisateur ;
		$this->documentheque = new Documentheque ;
		$this->communication = new Communication ;

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

	public function erasePermissions(){
		for($i = 0 ; $i < count($this->permissions) ; $i++) {
			$this->permissions[$i]->setProjet(null);
			$this->permissions->remove($i);
		}

		$this->permissions = new \Doctrine\Common\Collections\ArrayCollection(); ;
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

    /**
     * Set communication
     *
     * @param \Kub\CollaborationBundle\Entity\Communication $communication
     * @return Projet
     */
    public function setCommunication(\Kub\CollaborationBundle\Entity\Communication $communication = null)
    {
        $this->communication = $communication;
    
        return $this;
    }

    /**
     * Get communication
     *
     * @return \Kub\CollaborationBundle\Entity\Communication 
     */
    public function getCommunication()
    {
        return $this->communication;
    }
}