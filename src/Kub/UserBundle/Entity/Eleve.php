<?php

namespace Kub\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;

/**
 * Eleve
 *
 * @ORM\Entity
 * @ORM\Table()
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
     *
     * @Assert\Date()
     * @Assert\NotBlank()
     */
    private $anniversaire;

    public function initClasse()
    {
        $this->classe = "eleve";
    }

    public function __construct()
    {
        parent::__construct();

        $this->addRole("ROLE_ELEVE");
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