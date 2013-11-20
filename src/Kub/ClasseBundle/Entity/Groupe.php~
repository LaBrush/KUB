<?php

namespace Kub\ClasseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\Group as BaseGroup;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert ;


/**
 * Groupe
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Kub\ClasseBundle\Entity\GroupeRepository")
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
     * @Assert\NotNull()
     * @Assert\Length(
     *      min = "2",
     *      max = "255",
     *      minMessage = "Le nom du groupe doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom du groupe ne peut pas être plus long que {{ limit }} caractères"
     * )
     */
    protected $name ;

    /**
     * @ORM\Column(name="slug", type="string", length=255)
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug ;

    /**
     * @ORM\ManyToOne(targetEntity="Kub\ClasseBundle\Entity\Niveau", inversedBy="groupes"))
     *
     * @Assert\NotNull()
     */
    private $niveau ;

    /**
     * @ORM\ManyToMany(targetEntity="Kub\UserBundle\Entity\Eleve", inversedBy="groupes", cascade={"merge", "detach", "persist"}))
     */
    private $eleves ;


    /**
     * @ORM\ManyToMany(targetEntity="Kub\EDTBundle\Entity\Cours", mappedBy="groupes", cascade={"merge", "detach", "persist"})
     */
    private $cours ;

    public function __construct($name ="", $roles = array())
    {
        parent::__construct($name, $roles);

        $eleves = new \Doctrine\Common\Collections\ArrayCollection ;
    }

    public function __toString()
    {
        return $this->niveau . " " . $this->name ;
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
     * @param \Kub\ClasseBundle\Entity\Niveau $niveau
     * @return Groupe
     */
    public function setNiveau(\Kub\ClasseBundle\Entity\Niveau $niveau = null)
    {
        $this->niveau = $niveau;
    
        return $this;
    }

    /**
     * Get niveau
     *
     * @return \Kub\ClasseBundle\Entity\Niveau 
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Add eleves
     *
     * @param \Kub\UserBundle\Entity\Eleve $eleves
     * @return Groupe
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
     * Add cours
     *
     * @param \Kub\EDTBundle\Entity\Cours $cours
     * @return Groupe
     */
    public function addCour(\Kub\EDTBundle\Entity\Cours $cours)
    {
        $this->cours[] = $cours;
    
        return $this;
    }

    /**
     * Remove cours
     *
     * @param \Kub\EDTBundle\Entity\Cours $cours
     */
    public function removeCour(\Kub\EDTBundle\Entity\Cours $cours)
    {
        $this->cours->removeElement($cours);
    }

    /**
     * Get cours
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCours()
    {
        return $this->cours;
    }
}