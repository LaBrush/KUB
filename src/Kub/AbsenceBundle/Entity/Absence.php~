<?php

namespace Kub\AbsenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Absence
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Absence
{
	CONST PRESENT  = 0 ;
	CONST ABSENCE  = 1 ;
	CONST RETARD   = 2 ;
	CONST JUSTIFIE = 3 ;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
     * @ORM\ManyToOne(targetEntity="Kub\AbsenceBundle\Entity\Appel", inversedBy="absences", cascade={"merge", "detach", "persist"})
     */
    private $appel ;

	/** 
	 * @ORM\Column(name="statut", type="integer")
	 */
	private $statut ;

	/**
	 * @ORM\ManyToOne(targetEntity="Kub\UserBundle\Entity\Eleve")
	 */
	private $eleve ;

	public function __construct()
	{
		$this->statut = self::PRESENT ;
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
     * Set statut
     *
     * @param integer $statut
     * @return Absence
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;
    
        return $this;
    }

    /**
     * Get statut
     *
     * @return integer 
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set appel
     *
     * @param \Kub\AbsenceBundle\Entity\Appel $appel
     * @return Absence
     */
    public function setAppel(\Kub\AbsenceBundle\Entity\Appel $appel = null)
    {
        $this->appel = $appel;
    
        return $this;
    }

    /**
     * Get appel
     *
     * @return \Kub\AbsenceBundle\Entity\Appel 
     */
    public function getAppel()
    {
        return $this->appel;
    }

    /**
     * Set eleve
     *
     * @param \Kub\UserBundle\Entity\Eleve $eleve
     * @return Absence
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