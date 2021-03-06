<?php

namespace Kub\CollaborationBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert ;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotNull()
     * @Assert\Length(max=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=20)
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="Kub\CollaborationBundle\Entity\Tache", mappedBy="listeTaches", cascade={"all"})
     */
    private $taches ;

    /**
     * @ORM\ManyToOne(targetEntity="Kub\CollaborationBundle\Entity\Organisateur", cascade={"persist"}, inversedBy="listeTaches")
     */
    private $organisateur ;

    public function countCheckedTaches(){

        $c = 0 ;
        $taches = $this->getTaches();

        for ($i=0; $i < count($taches); $i++) { 
            if($taches[$i]->getDone())
            {
                $c++ ;
            }
        }

        return $c ;
    }

    public function __toString()
    {
        return $this->name ;
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

    /**
     * Set name
     *
     * @param string $name
     * @return ListeTaches
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
     * Set slug
     *
     * @param string $slug
     * @return ListeTaches
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
}