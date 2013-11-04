<?php

namespace Kub\EDTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;
use Kub\EDTBundle\Entity\Horaire ;

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
     * @ORM\OneToMany(targetEntity="Kub\EDTBundle\Entity\Horaire", mappedBy="cours", cascade={"persist", "remove"})
     * @Assert\Count(min=1, minMessage="Un cours doit avoir au moins un horaire")
     * @Assert\Valid()
     */
    private $horaires ;    

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

        $name = "Cours de avec " . $this->professeur . ' et ' . $groupesNames ;
        return $name ;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->groupes = new \Doctrine\Common\Collections\ArrayCollection();

        $this->addHoraire(new Horaire());
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
     * Add groupes
     *
     * @param \Kub\ClasseBundle\Entity\Groupe $groupes
     * @return Cours
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

    /**
     * Add horaires
     *
     * @param \Kub\EDTBundle\Entity\Horaire $horaires
     * @return Cours
     */
    public function addHoraire(\Kub\EDTBundle\Entity\Horaire $horaires)
    {
        $this->horaires[] = $horaires;

        $horaires->setCours($this);
    
        return $this;
    }

    /**
     * Remove horaires
     *
     * @param \Kub\EDTBundle\Entity\Horaire $horaires
     */
    public function removeHoraire(\Kub\EDTBundle\Entity\Horaire $horaires)
    {
        $this->horaires->removeElement($horaires);
        $horaires->setCours();
    }

    /**
     * Get horaires
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHoraires()
    {
        return $this->horaires;
    }
}