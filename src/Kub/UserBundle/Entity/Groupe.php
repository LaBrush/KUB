<?php

namespace Kub\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\Group as BaseGroup;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * Groupe
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Kub\UserBundle\Entity\GroupeRepository")
 */
class Groupe extends BaseGroup
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="slug", type="string", length=255)
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug ;

    /**
     * @ORM\ManyToOne(targetEntity="Kub\UserBundle\Entity\Niveau", inversedBy="groupes"))
     */
    private $niveau ;

    /**
     * @ORM\ManyToMany(targetEntity="Kub\UserBundle\Entity\Niveau", inversedBy="groupes"))
     */
    private $eleves ;


    public function __construct($name ="", $roles = array())
    {
        parent::__construct($name, $roles);
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
     * Set slug
     *
     * @param string $slug
     * @return Groupe
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

    /**
     * Set niveau
     *
     * @param \Kub\UserBundle\Entity\Niveau $niveau
     * @return Groupe
     */
    public function setNiveau(\Kub\UserBundle\Entity\Niveau $niveau = null)
    {
        $this->niveau = $niveau;
    
        return $this;
    }

    /**
     * Get niveau
     *
     * @return \Kub\UserBundle\Entity\Niveau 
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Add eleves
     *
     * @param \Kub\UserBundle\Entity\Niveau $eleves
     * @return Groupe
     */
    public function addEleve(\Kub\UserBundle\Entity\Niveau $eleves)
    {
        $this->eleves[] = $eleves;
    
        return $this;
    }

    /**
     * Remove eleves
     *
     * @param \Kub\UserBundle\Entity\Niveau $eleves
     */
    public function removeEleve(\Kub\UserBundle\Entity\Niveau $eleves)
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
}