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
	CONST ABSENCE = 0 ;
	CONST RETARD = 1 ;
	CONST JUSTIFIE = 2 ;

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
	 * @ORM\Column(name="statut", type="integer")
	 */
	private $statut ;

	/**
	 * @ORM\ManyToOne(targetEntity="Kub\EDTBundle\Entity\Cours")
	 */
	private $cours ;

	/**
	 * @ORM\ManyToOne(targetEntity="Kub\UserBundle\Entity\Eleve")
	 */
	private $eleve ;

	public function __construct()
	{
		$this->statut = self::ABSENCE ;
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
	 * Set date
	 *
	 * @param \DateTime $date
	 * @return Absence
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
     * Set cours
     *
     * @param \Kub\EDTBundle\Entity\Cours $cours
     * @return Absence
     */
    public function setCours(\Kub\EDTBundle\Entity\Cours $cours = null)
    {
        $this->cours = $cours;
    
        return $this;
    }

    /**
     * Get cours
     *
     * @return \Kub\EDTBundle\Entity\Cours 
     */
    public function getCours()
    {
        return $this->cours;
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