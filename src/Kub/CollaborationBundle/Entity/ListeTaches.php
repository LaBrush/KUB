<?php

namespace Kub\CollaborationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ListeTaches
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ListeTaches
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
     * @var integer
     *
     * @ORM\Column(name="rang", type="integer")
     */
    private $rang;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="Kub\CollaborationBundle\Entity\Tache", mappedBy="listeTaches", cascade={"all"})
     */
    private $taches ;

    /**
     * @ORM\ManyToOne(targetEntity="Kub\CollaborationBundle\Entity\Organisateur", cascade={"persist"}, inversedBy="listeTaches")
     */
    private $organisateur ;

    public function __toString()
    {
        return $this->nom ;
    }

    public function __construct()
    {
        $this->rang = 1 ;
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
     * Set rang
     *
     * @param integer $rang
     * @return ListeTaches
     */
    public function setRang($rang)
    {
        $this->rang = $rang;
    
        return $this;
    }

    /**
     * Get rang
     *
     * @return integer 
     */
    public function getRang()
    {
        return $this->rang;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return ListeTaches
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
     * Add taches
     *
     * @param \Kub\CollaborationBundle\Entity\Tache $taches
     * @return ListeTaches
     */
    public function addTache(\Kub\CollaborationBundle\Entity\Tache $taches)
    {
        $this->taches[] = $taches;
    
        return $this;
    }

    /**
     * Remove taches
     *
     * @param \Kub\CollaborationBundle\Entity\Tache $taches
     */
    public function removeTache(\Kub\CollaborationBundle\Entity\Tache $taches)
    {
        $this->taches->removeElement($taches);
    }

    /**
     * Get taches
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTaches()
    {
        return $this->taches;
    }

    /**
     * Set organisateur
     *
     * @param \Kub\CollaborationBundle\Entity\Organisateur $organisateur
     * @return ListeTaches
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
}