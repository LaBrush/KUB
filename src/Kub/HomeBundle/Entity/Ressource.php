<?php

namespace Kub\HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;
use Symfony\Component\Validator\ExecutionContextInterface  ;

/**
 * Ressource
 *
 * @ORM\MappedSuperclass
 * @Assert\Callback(groups={"file"}, methods={"isFileValid"})
 */
abstract class Ressource
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
     * @Assert\Length(max=255)
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
     * @ORM\ManyToOne(targetEntity="Kub\UserBundle\Entity\User", cascade={"merge", "detach", "persist"})
     */
    private $depositaire ;

    /**
     * @var string
     *
     * @ORM\Column(name="auteur", type="text", length=255)
     * @Assert\NotNull
     * @Assert\Length(min="2", max=255)
     */
    private $auteur ;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="text", nullable=true)
     * @Assert\Url(groups={"web"})
     * @Assert\NotNull(groups={"web"})
     */
    private $url;

    private $file ;

    /**
     * @ORM\Column(name="type", type="integer")
     */
    private $type ;

    
    public function isFileValid(ExecutionContextInterface $context)
    {   
        if($this->file && !($this->file->getFile() instanceof Symfony\Component\HttpFoundation\File\UploadedFile))
        {
            $context->addViolationAt('file', "La ressource n'a pas de fichier", array(), null);
        }
        
    }

    public function __toString()
    {
        return $this->titre;
    }

    public function __construct()
    {
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
     * Set auteur
     *
     * @param string $auteur
     * @return Ressource
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;
    
        return $this;
    }

    /**
     * Get auteur
     *
     * @return string 
     */
    public function getAuteur()
    {
        return $this->auteur;
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
     * Get file
     *
     * @return \Kub\RessourceBundle\Entity\File 
     */
    public function getFile()
    {
        return $this->file;
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