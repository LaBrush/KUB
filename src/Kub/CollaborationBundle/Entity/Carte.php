<?php

namespace Kub\CollaborationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Carte
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Kub\CollaborationBundle\Entity\CarteRepository")
 */
class Carte
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
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="sujet", type="text")
     */
    private $sujet;

    /**
     * @var boolean
     *
     * @ORM\Column(name="openWrite", type="boolean")
     */
    private $openWrite;


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
     * @return Carte
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
     * Set sujet
     *
     * @param string $sujet
     * @return Carte
     */
    public function setSujet($sujet)
    {
        $this->sujet = $sujet;
    
        return $this;
    }

    /**
     * Get sujet
     *
     * @return string 
     */
    public function getSujet()
    {
        return $this->sujet;
    }

    /**
     * Set openWrite
     *
     * @param boolean $openWrite
     * @return Carte
     */
    public function setOpenWrite($openWrite)
    {
        $this->openWrite = $openWrite;
    
        return $this;
    }

    /**
     * Get openWrite
     *
     * @return boolean 
     */
    public function getOpenWrite()
    {
        return $this->openWrite;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Carte
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
}