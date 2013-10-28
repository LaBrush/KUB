<?php

namespace Kub\EDTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;

/**
 * Cours
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Cours
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
     * @ORM\Column(name="debut", type="time")
     */
    private $debut;

    /**
     *
     */
    private $jour ;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fin", type="time")
     */
    private $fin;

    /**
     * @ORM\ManyToMany(targetEntity="Kub\ClasseBundle\Entity\Groupe", inversedBy="cours", cascade={"persist"})
     * @Assert\Count(min=1)
     */
    private $groupes ;

    /** 
     * @ORM\ManyToOne(targetEntity="Kub\UserBundle\Entity\Professeur", inversedBy="cours")
     * @Assert\NotNull()
     */
    private $professeur ;

    /** 
     * @ORM\ManyToOne(targetEntity="Kub\EDTBundle\Entity\Matiere")
     * @Assert\NotNull()
     */
    private $matiere ;

    /**
     * @ORM\ManyToMany(targetEntity="Kub\EDTBundle\Entity\Semaine")
     * @Assert\NotNull()
     */
    private $semaines ;

    /**
     * @Assert\True(message="Un cours ne peut avoir d'éléves de niveau différents")
     */
    public function isMonoLevel()
    {
        if(count($this->groupes))
        {
            $groupes = $this->groupes ;
            $niveauRef = $groupes[0]->getNiveau();

            foreach ($groupes as $key => $groupe) {
                
                if($groupe->getNiveau() != $niveauRef)
                {
                    return false ;
                }

            }

            return true ;
        }

        return true ;
    }

    public function __toString()
    {
        $groupesNames = "" ;

        foreach ($this->groupes as $key => $groupe) {
            $groupesNames .= $groupe . "a ";
        }

        $name = "Cours de " . $this->debut->format("H:i") . " à " . $this->fin->format("H:i") . " avec " . $this->professeur . ' et ' . $groupesNames ;
        return $name ;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->groupes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->semaines = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set debut
     *
     * @param \DateTime $debut
     * @return Cours
     */
    public function setDebut($debut)
    {
        $this->debut = $debut;
    
        return $this;
    }

    /**
     * Get debut
     *
     * @return \DateTime 
     */
    public function getDebut()
    {
        return $this->debut;
    }

    /**
     * Set fin
     *
     * @param \DateTime $fin
     * @return Cours
     */
    public function setFin($fin)
    {
        $this->fin = $fin;
    
        return $this;
    }

    /**
     * Get fin
     *
     * @return \DateTime 
     */
    public function getFin()
    {
        return $this->fin;
    }

    /**
     * Add groupes
     *
     * @param \Kub\ClasseBundle\Entity\Groupe $groupes
     * @return Cours
     */
    public function addGroupe(\Kub\ClasseBundle\Entity\Groupe $groupes)
    {
        $this->groupes[] = $groupes;
        $groupes->addCours($this);
    
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
        $groupes->removeCours($this);
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
     * Set professeur
     *
     * @param \Kub\UserBundle\Entity\Professeur $professeur
     * @return Cours
     */
    public function setProfesseur(\Kub\UserBundle\Entity\Professeur $professeur = null)
    {
        $this->professeur = $professeur;
    
        return $this;
    }

    /**
     * Get professeur
     *
     * @return \Kub\UserBundle\Entity\Professeur 
     */
    public function getProfesseur()
    {
        return $this->professeur;
    }

    /**
     * Add semaines
     *
     * @param \Kub\EDTBundle\Entity\Semaine $semaines
     * @return Cours
     */
    public function addSemaine(\Kub\EDTBundle\Entity\Semaine $semaines)
    {
        $this->semaines[] = $semaines;
    
        return $this;
    }

    /**
     * Remove semaines
     *
     * @param \Kub\EDTBundle\Entity\Semaine $semaines
     */
    public function removeSemaine(\Kub\EDTBundle\Entity\Semaine $semaines)
    {
        $this->semaines->removeElement($semaines);
    }

    /**
     * Get semaines
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSemaines()
    {
        return $this->semaines;
    }

    /**
     * Set matiere
     *
     * @param \Kub\EDTBundle\Entity\Matiere $matiere
     * @return Cours
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
}