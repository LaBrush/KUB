<?php

namespace Kub\RessourceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;
use Symfony\Component\Validator\ExecutionContextInterface  ;

use Kub\HomeBundle\Entity\Ressource as BaseRessource ;

/**
 * Ressource
 *
 * @ORM\Table(name="ressource_Ressource")
 * @ORM\Entity(repositoryClass="Kub\RessourceBundle\Entity\RessourceRepository")
 */
class Ressource extends BaseRessource 
{
    /**
     * @ORM\ManyToOne(targetEntity="Kub\EDTBundle\Entity\Matiere")
     */
    private $matiere ;

    /**
     * @ORM\ManyToOne(targetEntity="Kub\ClasseBundle\Entity\Niveau")
     */
    private $niveau ;

    /**
     * @ORM\OneToOne(targetEntity="Kub\RessourceBundle\Entity\File", cascade={"all"})
     */
    private $file ;

    /**
     * @var string
     *
     * @ORM\Column(name="valide", type="boolean")
     */
    private $valide;

    /**
     * @ORM\OneToOne(targetEntity="Kub\NotificationBundle\Entity\NewRessourceNotification", inversedBy="ressource",  cascade={"all"})
     */
    private $notification ;

    public function __construct()
    {
        parent::__construct();
        $this->valide = true ;
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
     * Set notification
     *
     * @param \Kub\NotificationBundle\Entity\NewRessourceNotification $notification
     * @return Ressource
     */
    public function setNotification(\Kub\NotificationBundle\Entity\NewRessourceNotification $notification = null)
    {
        $this->notification = $notification;
    
        return $this;
    }

    /**
     * Get notification
     *
     * @return \Kub\NotificationBundle\Entity\NewRessourceNotification 
     */
    public function getNotification()
    {
        return $this->notification;
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
}