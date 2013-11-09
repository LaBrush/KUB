<?php

namespace Kub\ArianeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fil
 *
 * @ORM\Table()
 * @ORM\Entity
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
     * @ORM\OneToMany(targetEntity="Kub\ArianeBundle\Entity\Post", mappedBy="fil")
     */
    private $posts ;


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
}