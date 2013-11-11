<?php

namespace Kub\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;


/**
 * Tuteur
 * @ORM\Entity
 * @ORM\Table()
 *
 * @ORM\Entity(repositoryClass="Kub\UserBundle\Entity\TuteurRepository")
 */

class Tuteur extends User
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
     * @var integer
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=true)
     */
    private $adresse ;


    /**
     * @var integer
     *
     * @ORM\Column(name="mobile", type="phone_number", nullable=true)
     *
     * @AssertPhoneNumber(defaultRegion="FR")
     */
    private $mobile ;

    /**
     * @var integer
     *
     * @ORM\Column(name="fixe", type="phone_number", nullable=true)
     *
     * @AssertPhoneNumber(defaultRegion="FR")
     */
    private $fixe ;

    /**
     * @ORM\ManyToMany(targetEntity="Kub\UserBundle\Entity\Eleve", mappedBy="tuteurs", cascade={"all"})
     * @ORM\JoinTable(name="tuteur_eleve")
     */

    private $eleves ;

    public function initClass()
    {
        $this->class = "tuteur";
    }

    public function __construct()
    {
        parent::__construct();

        $this->addRole("ROLE_TUTEUR");
        $this->eleves = new \Doctrine\Common\Collections\ArrayCollection;
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
     * Set adresse
     *
     * @param string $adresse
     * @return Tuteur
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    
        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set mobile
     *
     * @param phone_number $mobile
     * @return Tuteur
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    
        return $this;
    }

    /**
     * Get mobile
     *
     * @return phone_number 
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set fixe
     *
     * @param phone_number $fixe
     * @return Tuteur
     */
    public function setFixe($fixe)
    {
        $this->fixe = $fixe;
    
        return $this;
    }

    /**
     * Get fixe
     *
     * @return phone_number 
     */
    public function getFixe()
    {
        return $this->fixe;
    }

    /**
     * Add eleves
     *
     * @param \Kub\UserBundle\Entity\Eleve $eleves
     * @return Tuteur
     */
    public function addEleve(\Kub\UserBundle\Entity\Eleve $eleves)
    {
        $this->eleves[] = $eleves;
    
        return $this;
    }

    /**
     * Remove eleves
     *
     * @param \Kub\UserBundle\Entity\Eleve $eleves
     */
    public function removeEleve(\Kub\UserBundle\Entity\Eleve $eleves)
    {
        $this->eleves->removeElement($eleves);
    }

    /**
     * Get eleves
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEleves()
    {
        return $this->eleves;
    }
}