<?php

namespace Kub\ArianeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;

/**
 * Post
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Kub\ArianeBundle\Entity\PostRepository")
 */
class Post
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
	 * @ORM\ManyToOne(targetEntity="Kub\ArianeBundle\Entity\Fil", inversedBy="posts")
	 */
	private $fil ;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="debut", type="date")
	 * @Assert\Date()
	 */
	private $debut;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="fin", type="date")
	 * @Assert\Date()
	 */
	private $fin;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="date_ajout", type="datetime")
	 */
	private $dateAjout;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="titre", type="string", length=255)
	 * @Assert\NotNull()
	 */
	private $titre;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="contenu", type="text")
	 * @Assert\NotNull()
	 */
	private $contenu;

	/**
	 * @ORM\OneToMany(targetEntity="Kub\ArianeBundle\Entity\Commentaire", mappedBy="post", cascade={"persist", "remove"})
	 */
	private $commentaires; 

	public function __construct()
	{
		$this->dateAjout = new \DateTime();

		$this->debut = new \DateTime('yesterday');
		$this->fin = new \Datetime('now');
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
	 * Set debut
	 *
	 * @param \DateTime $debut
	 * @return Post
	 */
	public function setDebut($debut)
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
	 * @return Post
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
	 * Set text
	 *
	 * @param string $text
	 * @return Post
	 */
	public function setText($text)
	{
		$this->text = $text;
	
		return $this;
	}

	/**
	 * Get text
	 *
	 * @return string 
	 */
	public function getText()
	{
		return $this->text;
	}

	/**
	 * Set fil
	 *
	 * @param \Kub\ArianeBundle\Entity\Fil $fil
	 * @return Post
	 */
	public function setFil(\Kub\ArianeBundle\Entity\Fil $fil = null)
	{
		$this->fil = $fil;

		return $this;
	}

	/**
	 * Get fil
	 *
	 * @return \Kub\ArianeBundle\Entity\Fil 
	 */
	public function getFil()
	{
		return $this->fil;
	}

	/**
	 * Set dateAjout
	 *
	 * @param \DateTime $dateAjout
	 * @return Post
	 */
	public function setDateAjout($dateAjout)
	{
		$this->dateAjout = $dateAjout;
	
		return $this;
	}

	/**
	 * Get dateAjout
	 *
	 * @return \DateTime 
	 */
	public function getDateAjout()
	{
		return $this->dateAjout;
	}

	/**
	 * Set titre
	 *
	 * @param string $titre
	 * @return Post
	 */
	public function setTitre($titre)
	{
		$this->titre = $titre;
	
		return $this;
	}

	/**
	 * Get titre
	 *
	 * @return string 
	 */
	public function getTitre()
	{
		return $this->titre;
	}

	/**
	 * Add commentaires
	 *
	 * @param \Kub\ArianeBundle\Entity\Commentaire $commentaires
	 * @return Post
	 */
	public function addCommentaire(\Kub\ArianeBundle\Entity\Commentaire $commentaires)
	{
		$this->commentaires[] = $commentaires;
	
		return $this;
	}

	/**
	 * Remove commentaires
	 *
	 * @param \Kub\ArianeBundle\Entity\Commentaire $commentaires
	 */
	public function removeCommentaire(\Kub\ArianeBundle\Entity\Commentaire $commentaires)
	{
		$this->commentaires->removeElement($commentaires);
	}

	/**
	 * Get commentaires
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getCommentaires()
	{
		return $this->commentaires;
	}

    /**
     * Set contenu
     *
     * @param string $contenu
     * @return Post
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