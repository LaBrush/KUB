<?php

namespace Kub\EDTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;

/**
 * Frequence
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Frequence
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
     * @ORM\Column(name="nom", type="string", length=255)
     * @Assert\NotNull()
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="Kub\EDTBundle\Entity\Semaine")
     */
    private $semaines ;

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
        $this->semaines = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __tostring()
    {
        return $this->name ;
    }
    

    /**
     * @Assert\GreaterThanOrEqual(value=1, message="Une fréquence ne peut avoir moins d'une semaine")
     */
    public function getSemainesNumber(){

        return count($this->semaines);

    }

    /**
     * Add semaines
     *
     * @param \Kub\EDTBundle\Entity\Semaine $semaines
     * @return Frequence
     */
    public function addSemaine(\Kub\EDTBundle\Entity\Semaine $semaines)
    {
        $this->semaines[] = $semaines;
    
        return $this;
    }

    /**
     * Remove semaines
     *
     * @param \Kub\EDTBundle\Entity\Semaine $semaines
     */
    public function removeSemaine(\Kub\EDTBundle\Entity\Semaine $semaines)
    {
        $this->semaines->removeElement($semaines);
    }

    /**
     * Get semaines
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSemaines()
    {
        return $this->semaines;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Frequence
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
}