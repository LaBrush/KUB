<?php

namespace Kub\CollaborationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tache
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Tache
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
     * @var \DateTime
     *
     * @ORM\Column(name="echeance", type="date")
     */
    private $echeance;

    /**
     * @ORM\ManyToOne(targetEntity="Kub\CollaborationBundle\Entity\Organisateur", cascade={"persist"}, inversedBy="taches")
     */
    private $organisateur ;

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
     * @return Tache
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
     * Set echeance
     *
     * @param \DateTime $echeance
     * @return Tache
     */
    public function setEcheance($echeance)
    {
        $this->echeance = $echeance;
    
        return $this;
    }

    /**
     * Get echeance
     *
     * @return \DateTime 
     */
    public function getEcheance()
    {
        return $this->echeance;
    }

    /**
     * Set organisateur
     *
     * @param \Kub\CollaborationBundle\Entity\Organisateur $organisateur
     * @return Tache
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