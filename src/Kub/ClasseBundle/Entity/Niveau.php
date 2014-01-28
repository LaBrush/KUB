<?php

namespace Kub\ClasseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection ;
use Symfony\Component\Validator\Constraints as Assert ;


/**
 * Niveau
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Niveau
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\Length(max=255, min=2)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="abreviation", type="string", length=10)
     */
    private $abreviation;

    /**
     * @var integer
     *
     * @ORM\Column(name="annee", type="integer")
     */
    private $annee;

    /**
     * @ORM\OneToMany(targetEntity="Kub\UserBundle\Entity\Eleve", mappedBy="niveau"))
     */
    private $eleves ;

    /**
     * @ORM\OneToMany(targetEntity="Kub\ClasseBundle\Entity\Groupe", mappedBy="niveau"))
     */
    private $groupes;

    public function __construct()
    {
        $this->eleves = new ArrayCollection;
        $this->groupes = new ArrayCollection;
    }

    public function __toString()
    {
        return $this->name ;
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
     * Set name
     *
     * @param string $name
     * @return Niveau
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
     * Set annee
     *
     * @param integer $annee
     * @return Niveau
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;
    
        return $this;
    }

    /**
     * Get annee
     *
     * @return integer 
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Add eleves
     *
     * @param \Kub\UserBundle\Entity\Eleve $eleves
     * @return Niveau
     */
    public function addEleve(\Kub\UserBundle\Entity\Eleve $eleves)
    {
        $this->eleves[] = $eleves;
    
        return $this;
    }

    /**
     * Remove eleves
     *
     * @param \Kub\UserBundle\Entity\Eleve $eleves
     */
    public function removeEleve(\Kub\UserBundle\Entity\Eleve $eleves)
    {
        $this->eleves->removeElement($eleves);
    }

    /**
     * Get eleves
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEleves()
    {
        return $this->eleves;
    }

    /**
     * Set eleves
     *
     * @param \Kub\UserBundle\Entity\Eleve $eleves
     * @return Niveau
     */
    public function setEleves(\Kub\UserBundle\Entity\Eleve $eleves = null)
    {
        $this->eleves = $eleves;
    
        return $this;
    }

    /**
     * Set groupes
     *
     * @param \Kub\ClasseBundle\Entity\Groupe $groupes
     * @return Niveau
     */
    public function setGroupes(\Kub\ClasseBundle\Entity\Groupe $groupes = null)
    {
        $this->groupes = $groupes;
    
        return $this;
    }

    /**
     * Get groupes
     *
     * @return \Kub\ClasseBundle\Entity\Groupe 
     */
    public function getGroupes()
    {
        return $this->groupes;
    }

    /**
     * Add groupes
     *
     * @param \Kub\ClasseBundle\Entity\Groupe $groupes
     * @return Niveau
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
     * Set abreviation
     *
     * @param string $abreviation
     * @return Niveau
     */
    public function setAbreviation($abreviation)
    {
        $this->abreviation = $abreviation;
    
        return $this;
    }

    /**
     * Get abreviation
     *
     * @return string 
     */
    public function getAbreviation()
    {
        return $this->abreviation;
    }
}