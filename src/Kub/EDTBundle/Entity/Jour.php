<?php

namespace Kub\EDTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jour
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Jour
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
     * @ORM\Column(name="ref", type="integer")
     */
    private $ref;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\Length(max=255)
     */
    private $name;


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
     * @return Jour
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
     * Set ref
     *
     * @param integer $ref
     * @return Jour
     */
    public function setRef($ref)
    {
        $this->ref = $ref;
    
        return $this;
    }

    /**
     * Get ref
     *
     * @return integer 
     */
    public function getRef()
    {
        return $this->ref;
    }
}