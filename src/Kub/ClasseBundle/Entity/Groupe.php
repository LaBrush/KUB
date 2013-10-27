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
     * @ORM\ManyToMany(targetEntity="Kub\UserBundle\Entity\Eleve", inversedBy="groupes"))
     */
    private $eleves ;


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
     * @param \Kub\ClasseBundle\Entity\Niveau $eleves
     * @return Groupe
     */
    public function addEleve(\Kub\ClasseBundle\Entity\Niveau $eleves)
    {
        $this->eleves[] = $eleves;
        $eleves->addGroup($this);
    
        return $this;
    }

    /**
     * Remove eleves
     *
     * @param \Kub\ClasseBundle\Entity\Niveau $eleves
     */
    public function removeEleve(\Kub\ClasseBundle\Entity\Niveau $eleves)
    {
        $this->eleves->removeElement($eleves);
        $eleves->removeGroupe($this);
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
     * Add niveau
     *
     * @param \Kub\ClasseBundle\Entity\Niveau $niveau
     * @return Groupe
     */
    public function addNiveau(\Kub\ClasseBundle\Entity\Niveau $niveau)
    {
        $this->niveau[] = $niveau;
        $niveau->addGroupe($this);
    
        return $this;
    }

    /**
     * Remove niveau
     *
     * @param \Kub\ClasseBundle\Entity\Niveau $niveau
     */
    public function removeNiveau(\Kub\ClasseBundle\Entity\Niveau $niveau)
    {
        $this->niveau->removeElement($niveau);
        $niveau->removeElement($this);
    }
}