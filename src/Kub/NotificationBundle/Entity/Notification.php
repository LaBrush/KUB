<?php

namespace Kub\NotificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Notification
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var boolean
     *
     * @ORM\Column(name="everyone", type="boolean")
     */
    private $everyone;

    /**
     * @ORM\Column(name="description", type="array")
     */
    private $descriptionArguments ;

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
     * Set date
     *
     * @param \DateTime $date
     * @return Notification
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set everyone
     *
     * @param boolean $everyone
     * @return Notification
     */
    public function setEveryone($everyone)
    {
        $this->everyone = $everyone;
    
        return $this;
    }

    /**
     * Get everyone
     *
     * @return boolean 
     */
    public function getEveryone()
    {
        return $this->everyone;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Notification
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    
        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     * @return Notification
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    
        return $this;
    }

    /**
     * Get contenu
     *
     * @return string 
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set descriptionArguments
     *
     * @param array $descriptionArguments
     * @return Notification
     */
    public function setDescriptionArguments($descriptionArguments)
    {
        $this->descriptionArguments = $descriptionArguments;
    
        return $this;
    }

    /**
     * Get descriptionArguments
     *
     * @return array 
     */
    public function getDescriptionArguments()
    {
        return $this->descriptionArguments;
    }
}