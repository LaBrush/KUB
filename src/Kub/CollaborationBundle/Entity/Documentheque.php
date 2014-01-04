<?php

namespace Kub\CollaborationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Documentheque
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Documentheque
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
     * @ORM\OneToMany(targetEntity="Kub\CollaborationBundle\Entity\Fichier", cascade={"all"}, mappedBy="documenteque")
     */
    private $fichiers ;

    /**
     * @ORM\OneToMany(targetEntity="Kub\CollaborationBundle\Entity\Ressource", cascade={"all"}, mappedBy="documenteque")
     */
    private $ressources ;

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
     * Constructor
     */
    public function __construct()
    {
        $this->fichiers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ressources = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add fichiers
     *
     * @param \Kub\CollaborationBundle\Entity\Fichier $fichiers
     * @return Documentheque
     */
    public function addFichier(\Kub\CollaborationBundle\Entity\Fichier $fichiers)
    {
        $this->fichiers[] = $fichiers;
    
        return $this;
    }

    /**
     * Remove fichiers
     *
     * @param \Kub\CollaborationBundle\Entity\Fichier $fichiers
     */
    public function removeFichier(\Kub\CollaborationBundle\Entity\Fichier $fichiers)
    {
        $this->fichiers->removeElement($fichiers);
    }

    /**
     * Get fichiers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFichiers()
    {
        return $this->fichiers;
    }

    /**
     * Add ressources
     *
     * @param \Kub\CollaborationBundle\Entity\Ressource $ressources
     * @return Documentheque
     */
    public function addRessource(\Kub\CollaborationBundle\Entity\Ressource $ressources)
    {
        $this->ressources[] = $ressources;
    
        return $this;
    }

    /**
     * Remove ressources
     *
     * @param \Kub\CollaborationBundle\Entity\Ressource $ressources
     */
    public function removeRessource(\Kub\CollaborationBundle\Entity\Ressource $ressources)
    {
        $this->ressources->removeElement($ressources);
    }

    /**
     * Get ressources
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRessources()
    {
        return $this->ressources;
    }
}