<?php

namespace Kub\AbsenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Appel
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Kub\AbsenceBundle\Entity\AppelRepository")
 */
class Appel
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
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Kub\EDTBundle\Entity\Cours")
     */
    private $cours ;

    /**
     * @ORM\ManyToOne(targetEntity="Kub\EDTBundle\Entity\Semaine")
     */
    private $semaine ;

    /**
     * @ORM\OneToMany(targetEntity="Kub\AbsenceBundle\Entity\Absence", mappedBy="appel", cascade={"merge", "detach", "persist"})
     */
    private $absences ;

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->absences = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function hasEleve($eleve)
    {
        foreach ($this->getAbsences() as $absence) {
            if($absence->hasEleve($eleve)){ return true ; }
        }

        return false ;
    }

    public function getEleves()
    {
        $eleves = array();
        foreach ($this->getCours()->getGroupes() as $groupe) {
            foreach ($groupe->getEleves() as $eleve) {
                $eleves[] = $eleve ;
            }
        }

        return $eleves ;
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
     * @return Appel
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
     * Set cours
     *
     * @param \Kub\EDTBundle\Entity\Cours $cours
     * @return Appel
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
     * Set semaine
     *
     * @param \Kub\EDTBundle\Entity\Semaine $semaine
     * @return Appel
     */
    public function setSemaine(\Kub\EDTBundle\Entity\Semaine $semaine = null)
    {
        $this->semaine = $semaine;
    
        return $this;
    }

    /**
     * Get semaine
     *
     * @return \Kub\EDTBundle\Entity\Semaine 
     */
    public function getSemaine()
    {
        return $this->semaine;
    }

    /**
     * Add absences
     *
     * @param \Kub\AbsenceBundle\Entity\Absence $absences
     * @return Appel
     */
    public function addAbsence(\Kub\AbsenceBundle\Entity\Absence $absences)
    {
        $this->absences[] = $absences;
        $absences->setAppel($this);
    
        return $this;
    }

    /**
     * Remove absences
     *
     * @param \Kub\AbsenceBundle\Entity\Absence $absences
     */
    public function removeAbsence(\Kub\AbsenceBundle\Entity\Absence $absences)
    {
        $this->absences->removeElement($absences);
        $absences->setAppel();
    }

    /**
     * Get absences
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAbsences()
    {
        return $this->absences;
    }
}