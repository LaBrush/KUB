<?php

namespace Kub\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;


/**
 * Eleve
 *
 * @ORM\Entity
 * @ORM\Table()
 * @UniqueEntity(fields = "username", targetClass = "Acme\UserBundle\Entity\User", message="fos_user.username.already_used")
 * @UniqueEntity(fields = "email", targetClass = "Acme\UserBundle\Entity\User", message="fos_user.email.already_used")
 */
class Eleve extends User 
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
     * @var \DateTime
     *
     * @ORM\Column(name="anniversaire", type="date")
     */
    private $anniversaire;


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
     * Set anniversaire
     *
     * @param \DateTime $anniversaire
     * @return Eleve
     */
    public function setAnniversaire($anniversaire)
    {
        $this->anniversaire = $anniversaire;
    
        return $this;
    }

    /**
     * Get anniversaire
     *
     * @return \DateTime 
     */
    public function getAnniversaire()
    {
        return $this->anniversaire;
    }
}
