<?php

namespace Kub\EDTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\OneToMany(targetEntity="Kub\ClasseBundle\Entity\Groupe", mappedBy="cours")
     */
    private $groupes ;

    /** 
     * @ORM\ManyToOne(targetEntity="Kub\UserBundle\Entity\Professeur", inversedBy="cours")
     */
    private $professeur ;


    /**
     * @ORM\ManyToMany(targetEntity="Kub\EDTBundle\Entity\Semaine")
     */
    private $semaines ;

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
    public function setDebut(\DateTime $debut)
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
     * Constructor
     */
    public function __construct()
    {
        $this->groupe = new \Doctrine\Common\Collections\ArrayCollection();
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
        if(!in_array($semaines, $this->semaines))
        {
            $this->semaines[] = $semaines;
        }

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
     * Get groupes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroupes()
    {
        return $this->groupes;
    }
}