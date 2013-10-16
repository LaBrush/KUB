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

    /**
     *  @ORM\ManyToMany(targetEntity="Kub\UserBundle\Entity\Tuteur", inversedBy="eleves", cascade={"persist"})
     */
    private $tuteurs ;

    public function initClass()
    {
        $this->class = "eleve";
    }

    public function __construct()
    {
        parent::__construct();

        $this->addRole("ROLE_ELEVE");
        $this->tuteurs = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     *  @Assert\LessThanOrEqual(
     *       value= 2,
     *       message="L'élève ne peut avoir plus de deux tuteurs")
     */
    public function getNumberOfTuteurs()
    {
        return count($this->tuteurs);
    }


    /**
     * Add tuteurs
     *
     * @param \Kub\UserBundle\Entity\Tuteur $tuteurs
     * @return Eleve
     */
    public function addTuteur(\Kub\UserBundle\Entity\Tuteur $tuteurs)
    {        
        $this->tuteurs[] = $tuteurs;
        $tuteurs->addEleve($this);
    
        return $this;
    }

    /**
     * Remove tuteurs
     *
     * @param \Kub\UserBundle\Entity\Tuteur $tuteurs
     */
    public function removeTuteur(\Kub\UserBundle\Entity\Tuteur $tuteurs)
    {
        $this->tuteurs->removeElement($tuteurs);
        $tuteurs->removeEleve($this);
    }

    /**
     * Get tuteurs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTuteurs()
    {
        return $this->tuteurs;
    }
}