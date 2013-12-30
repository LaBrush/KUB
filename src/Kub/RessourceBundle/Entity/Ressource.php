<?php

namespace Kub\RessourceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;

/**
 * Ressource
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Kub\RessourceBundle\Entity\RessourceRepository")
 */
class Ressource
{
    const WEB = 1 ;
    const FILE = 2 ;

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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Kub\UserBundle\Entity\User", cascade={"all"})
     */
    private $depositaire ;

    /**
     * @var string
     *
     * @ORM\Column(name="auteur", type="text", length=255)
     */
    private $auteur ;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="text", nullable=true)
     * @Assert\Url()
     */
    private $url;

    /**
     * @ORM\OneToOne(targetEntity="Kub\RessourceBundle\Entity\File", cascade={"all"})
     */
    private $file ;

    /**
     * @ORM\Column(name="type", type="integer")
     */
    private $type ;

    /**
     * @ORM\ManyToOne(targetEntity="Kub\EDTBundle\Entity\Matiere", cascade={"all"})
     */
    private $matiere ;

    /**
     * @ORM\ManyToOne(targetEntity="Kub\ClasseBundle\Entity\Niveau", cascade={"all"})
     */
    private $niveau ;

    /**
     * @var string
     *
     * @ORM\Column(name="valide", type="boolean")
     */
    private $valide;

    public function __toString()
    {
        return $this->titre;
    }

    public function __construct()
    {
        $this->valide = true ;
        $this->date = new \DateTime ;
        $this->type = Ressource::WEB ;
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
     * Set description
     *
     * @param string $description
     * @return Ressource
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
     * Set date
     *
     * @param \DateTime $date
     * @return Ressource
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
     * Set url
     *
     * @param string $url
     * @return Ressource
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set auteur
     * @return Ressource
     */
    public function setAuteur($auteur = null)
    {
        $this->auteur = $auteur;
    
        return $this;
    }

    /**
     * Get auteur
     *
     * @return \Kub\UserBundle\Entity\User 
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Ressource
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    
        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set file
     *
     * @param \Kub\RessourceBundle\Entity\File $file
     * @return Ressource
     */
    public function setFile(\Kub\RessourceBundle\Entity\File $file = null)
    {
        $this->file = $file;
    
        return $this;
    }

    /**
     * Get file
     *
     * @return \Kub\RessourceBundle\Entity\File 
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set matiere
     *
     * @param \Kub\EDTBundle\Entity\Matiere $matiere
     * @return Ressource
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
     * Set niveau
     *
     * @param \Kub\ClasseBundle\Entity\Niveau $niveau
     * @return Ressource
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
     * Set type
     *
     * @param integer $type
     * @return Ressource
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set valide
     *
     * @param boolean $valide
     * @return Ressource
     */
    public function setValide($valide)
    {
        $this->valide = $valide;
    
        return $this;
    }

    /**
     * Get valide
     *
     * @return boolean 
     */
    public function getValide()
    {
        return $this->valide;
    }

    /**
     * Set depositaire
     *
     * @param \Kub\UserBundle\Entity\User $depositaire
     * @return Ressource
     */
    public function setDepositaire(\Kub\UserBundle\Entity\User $depositaire = null)
    {
        $this->depositaire = $depositaire;
    
        return $this;
    }

    /**
     * Get depositaire
     *
     * @return \Kub\UserBundle\Entity\User 
     */
    public function getDepositaire()
    {
        return $this->depositaire;
    }
}