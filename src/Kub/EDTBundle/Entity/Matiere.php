<?php

namespace Kub\EDTBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert ;
use Doctrine\ORM\Mapping as ORM;

/**
 * Matiere
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Kub\EDTBundle\Entity\MatiereRepository")
 */
class Matiere
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
     * @Assert\Length(max=255)
     */
    private $name;

    /** 
     * @ORM\OneToMany(targetEntity="Kub\EDTBundle\Entity\Cours", mappedBy="matiere")
     */
    private $cours ;

    /**
     * @ORM\ManyToOne(targetEntity="Kub\EDTBundle\Entity\Categorie")
     */
    private $categorie ;

    public function getAbreviation()
    {
        $nom = str_replace(
            array(
                'à', 'â', 'ä', 'á', 'ã', 'å',
                'î', 'ï', 'ì', 'í', 
                'ô', 'ö', 'ò', 'ó', 'õ', 'ø', 
                'ù', 'û', 'ü', 'ú', 
                'é', 'è', 'ê', 'ë', 
                'ç', 'ÿ', 'ñ', ' ' 
            ),
            array(
                'a', 'a', 'a', 'a', 'a', 'a', 
                'i', 'i', 'i', 'i', 
                'o', 'o', 'o', 'o', 'o', 'o', 
                'u', 'u', 'u', 'u', 
                'e', 'e', 'e', 'e', 
                'c', 'y', 'n', '_'
            ),
            $this->nom
        );

        return strtolower($nom);
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
     * @return Matiere
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
     * Constructor
     */
    public function __construct()
    {
        $this->cours = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add cours
     *
     * @param \Kub\EDTBundle\Entity\Cours $cours
     * @return Matiere
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

    /**
     * Set categorie
     *
     * @param \Kub\EDTBundle\Entity\Categorie $categorie
     * @return Matiere
     */
    public function setCategorie(\Kub\EDTBundle\Entity\Categorie $categorie = null)
    {
        $this->categorie = $categorie;
    
        return $this;
    }

    /**
     * Get categorie
     *
     * @return \Kub\EDTBundle\Entity\Categorie 
     */
    public function getCategorie()
    {
        return $this->categorie;
    }
}