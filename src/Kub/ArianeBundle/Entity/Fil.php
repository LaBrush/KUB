<?php

namespace Kub\ArianeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fil
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Kub\ArianeBundle\Entity\FilRepository")
 */
class Fil
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
     * @ORM\OneToMany(targetEntity="Kub\ArianeBundle\Entity\Post", mappedBy="fil", cascade={"persist", "remove"})
     */
    private $posts ;

    /**
     * @ORM\OneToOne(targetEntity="Kub\UserBundle\Entity\Eleve", mappedBy="fil")
     */
    private $eleve ;

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
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add posts
     *
     * @param \Kub\ArianeBundle\Entity\Post $posts
     * @return Fil
     */
    public function addPost(\Kub\ArianeBundle\Entity\Post $posts)
    {
        $this->posts[] = $posts;
        $posts->setFil($this);
    
        return $this;
    }

    /**
     * Remove posts
     *
     * @param \Kub\ArianeBundle\Entity\Post $posts
     */
    public function removePost(\Kub\ArianeBundle\Entity\Post $posts)
    {
        $this->posts->removeElement($posts);
        $posts->setFil();
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Set eleve
     *
     * @param \Kub\UserBundle\Entity\Eleve $eleve
     * @return Fil
     */
    public function setEleve(\Kub\UserBundle\Entity\Eleve $eleve = null)
    {
        $this->eleve = $eleve;
    
        return $this;
    }

    /**
     * Get eleve
     *
     * @return \Kub\UserBundle\Entity\Eleve 
     */
    public function getEleve()
    {
        return $this->eleve;
    }
}