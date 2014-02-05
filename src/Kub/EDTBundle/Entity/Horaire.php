<?php

namespace Kub\EDTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;
use Kub\EDTBundle\Validator\Constraints as KAssert ;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * Horaire
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Kub\EDTBundle\Entity\HoraireRepository")
 *
 * @Assert\Callback(methods={"isNotNull"})
 *
 */
class Horaire
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
	 * @var \DateTime
	 *
	 * @ORM\Column(name="debut", type="time")
	 * @KAssert\TimeEDTCompatible()
	 * @Assert\Time()
	 */
	private $debut;

	/**
	 * @ORM\ManyToOne(targetEntity="Kub\EDTBundle\Entity\Jour")
	 * @Assert\NotNull()
	 */
	private $jour ;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="fin", type="time")
	 * @KAssert\TimeEDTCompatible()
	 * @Assert\Time()
	 */
	private $fin;

	/**
	 * @ORM\ManyToMany(targetEntity="Kub\EDTBundle\Entity\Semaine")
	 * @Assert\Count(
	 *      min=1, 
	 *      minMessage = "Un horaire doit avoir au moins une semaine dans l'année",
	 *      groups={"second_pass"}
	 * )
	 */
	private $semaines ;

	/** 
	 * @ORM\ManyToOne(targetEntity="Kub\EDTBundle\Entity\Cours", inversedBy="horaires", cascade={"all"})
	 */
	private $cours ;

	public function isNotNull(ExecutionContextInterface $context)
	{
		if(
			$this->debut->format('H') >= $this->fin->format('H') && 
			$this->debut->format('i') >= $this->fin->format('i')
		)
		{
			$context->addViolationAt('fin', 'Le cours ne peut pas finir avant de commencer', array(), null);
		}
	}

	public function contains(\Datetime $datetime)
	{
		if(
			$this->debut->format('H') < $datetime->format('H') &&
			$this->fin->format('H') > $datetime->format('H') ||

			(
				(
					$this->debut->format('H') == $datetime->format('H') &&
					$this->debut->format('i') < $datetime->format('i') 

				) ||
				(
					$this->fin->format('H') == $datetime->format('H') &&
					$this->fin->format('i') > $datetime->format('i') 
				)
			)
		)
		{
			return true ;
		}
		else 
		{
			return false ;
		}
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
	 * Add semaines
	 *
	 * @param \Kub\EDTBundle\Entity\Semaine $semaines
	 * @return Cours
	 */
	public function addSemaine(\Kub\EDTBundle\Entity\Semaine $semaines)
	{
		if(!$this->semaines->contains($semaines))
		{
			$this->semaines[] = $semaines;
		}
	
		return $this;
	}
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->semaines = new \Doctrine\Common\Collections\ArrayCollection;
	}
	
	public function __toString()
	{
		return "De " . $this->debut->format("H:i") . " à " . $this->fin->format("H:i") . " le " . $this->getJour() ;
	}

	/**
	 * Set debut
	 *
	 * @param \DateTime $debut
	 * @return Horaire
	 */
	public function setDebut(\Datetime $debut)
	{
		$this->debut = $debut;
	
		return $this;
	}

	/**
	 * Get debut
	 *
	 * @return \DateTime 
	 */
	public function getDebut()
	{
		return $this->debut;
	}

	/**
	 * Set fin
	 *
	 * @param \DateTime $fin
	 * @return Horaire
	 */
	public function setFin($fin)
	{
		$this->fin = $fin;
	
		return $this;
	}

	/**
	 * Get fin
	 *
	 * @return \DateTime 
	 */
	public function getFin()
	{
		return $this->fin;
	}

	/**
	 * Set jour
	 *
	 * @param \Kub\EDTBundle\Entity\Jour $jour
	 * @return Horaire
	 */
	public function setJour(\Kub\EDTBundle\Entity\Jour $jour = null)
	{
		$this->jour = $jour;
	
		return $this;
	}

	/**
	 * Get jour
	 *
	 * @return \Kub\EDTBundle\Entity\Jour 
	 */
	public function getJour()
	{
		return $this->jour;
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
	 * Set cours
	 *
	 * @param \Kub\EDTBundle\Entity\Cours $cours
	 * @return Horaire
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
}