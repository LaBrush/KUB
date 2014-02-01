<?php

namespace Kub\AbsenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Absence
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Kub\AbsenceBundle\Entity\AbsenceRepository")
 */
class Absence
{
	CONST PRESENT  = 0 ;
	CONST ABSENCE  = 1 ;
	CONST RETARD   = 2 ;

    CONST ATTENTE = 10 ;
	CONST JUSTIFIE = 11 ;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
     * @ORM\ManyToOne(targetEntity="Kub\AbsenceBundle\Entity\Appel", inversedBy="absences",  cascade={"all"})
     */
    private $appel ;

	/** 
     * @ORM\Column(name="statut", type="integer")
     */
    private $statut ;

    /** 
	 * @ORM\Column(name="type", type="integer")
	 */
	private $type ;

	/**
	 * @ORM\ManyToOne(targetEntity="Kub\UserBundle\Entity\Eleve")
	 */
	private $eleve ;

	public function __construct()
	{
        $this->type = self::PRESENT ;
		$this->statut = self::ATTENTE ;
	}

    public function __toString(){

        $appel = $this->getAppel();
        $heure = $appel->getHoraire();
        $date  = $appel->getDate();

        return 'Le ' . $date->format('d/m') . ' à ' . $heure->getDebut()->format('H\\hi');

    }

    public function hasEleve($eleve)
    {
        return $this->eleve == $eleve ;
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

    /**
     * Set type
     *
     * @param integer $type
     * @return Absence
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }
}