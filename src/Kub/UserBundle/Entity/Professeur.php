<?php

namespace Kub\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Professeur
 *
 * @ORM\Entity
 * @ORM\Table()
 *
 * @ORM\Entity(repositoryClass="Kub\UserBundle\Entity\ProfesseurRepository")
 */

class Professeur extends User
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
	 * @ORM\OneToMany(targetEntity="Kub\EDTBundle\Entity\Cours", mappedBy="professeur")
	 */
	private $cours ;

	public function getGroupes(){

		$groupes = array();
		foreach ($this->getCours() as $cours) {
			foreach ($cours->getGroupes() as $groupe) {

				$groupes[] = $groupe ;

			}
		}

		return $groupes ;
	}

	public function hasEleve($eleve){

		foreach ($this->getGroupes() as $groupe) {
			if($groupe->getEleves()->contains($eleve))
			{
				return true ;
			}
		}

		return false ;

	}

	public function initClass()
	{
		$this->class = "professeur";
	}

	public function __construct()
	{
		parent::__construct();

		$this->cours = new \Doctrine\Common\Collections\ArrayCollection;
		$this->addRole("ROLE_PROFESSEUR");
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
	 * Add cours
	 *
	 * @param \Kub\EDTBundle\Entity\Cours $cours
	 * @return Professeur
	 */
	public function addCour(\Kub\EDTBundle\Entity\Cours $cours)
	{
		$this->cours[] = $cours;
	
		return $this;
	}

	/**
	 * Remove cours
	 *
	 * @param \Kub\EDTBundle\Entity\Cours $cours
	 */
	public function removeCour(\Kub\EDTBundle\Entity\Cours $cours)
	{
		$this->cours->removeElement($cours);
	}

	/**
	 * Get cours
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getCours()
	{
		return $this->cours;
	}
}