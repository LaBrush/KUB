<?php

namespace Kub\CollaborationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;

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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\OneToOne(targetEntity="Kub\CollaborationBundle\Entity\Organisateur", cascade={"all"})
     */
    private $organisateur ;

    /**
     * @ORM\OneToOne(targetEntity="Kub\CollaborationBundle\Entity\Documentheque", cascade={"all"})
     */
    private $documentheque ;

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
}