<?php

namespace Kub\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection ;

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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

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

    public function __construct()
    {
        $this->eleves = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nom ;
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
     * Set nom
     *
     * @param string $nom
     * @return Niveau
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
}