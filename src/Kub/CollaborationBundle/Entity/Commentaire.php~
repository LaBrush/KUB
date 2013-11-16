<?php

namespace Kub\CollaborationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="collaboration_commentaire")
 * @ORM\Entity
 */
class Commentaire
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
	 * @var string
	 *
	 * @ORM\Column(name="contenu", type="text")
	 */
	private $contenu;

	/**
     * @ORM\ManyToOne(targetEntity="Kub\CollaborationBundle\Entity\Carte", inversedBy="commentaires", cascade={"persist", "merge"})
     */
    protected $carte;

    /**
     * @ORM\ManyToOne(targetEntity="Kub\UserBundle\Entity\User")
     */
    protected $auteur;

	/**
	 * @ORM\Column(name="date", type="datetime")
	 */
	protected $date ;

	public function __construct()
	{
		$this->date = new \DateTime();
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
	 * Set contenu
	 *
	 * @param string $contenu
	 * @return Commentaire
	 */
	public function setContenu($contenu)
	{
		$this->contenu = $contenu;
	
		return $this;
	}

	/**
	 * Get contenu
	 *
	 * @return string 
	 */
	public function getContenu()
	{
		return $this->contenu;
	}
}
