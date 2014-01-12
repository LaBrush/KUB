<?php

namespace Kub\CollaborationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fichier
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Fichier
{
	const PAD = 1 ;
	const CALC = 2 ;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="type", type="integer")
	 */
	private $type;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=255)
	 */
	private $name;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="date_ajout", type="datetime")
	 */
	private $dateAjout;

	/**
	 * @ORM\ManyToOne(targetEntity="Kub\CollaborationBundle\Entity\Documentheque", inversedBy="fichiers")
	 */
	private $documentheque ;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="url", type="string", length=40)
	 */
	private $url;

	public function getWebPath()
	{
		return $this->getDomain() . 'kub' . $this->getUrl() . $this->getId() ;
	}

	public function getDomain()
	{
		$domain = '';
		switch ($this->type) {
			case self::PAD:
				$domain = "http://openetherpad.org/p/";
				break;
			case self::CALC:
				$domain = "http://ethercalc.crdp.ac-versailles.fr/";
				break;
		}

		return $domain ;
	}

	public function __toString()
	{
		return $this->name ;
	}

	public function __construct()
	{
		$this->dateAjout = new \DateTime ;
		$this->url = substr(
			uniqid(hash("sha1", str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"))),
			1, 40
		);
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
	 * Set type
	 *
	 * @param integer $type
	 * @return Fichier
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

	/**
	 * Set name
	 *
	 * @param string $name
	 * @return Fichier
	 */
	public function setName($name)
	{
		$this->name = $name;
	
		return $this;
	}

	/**
	 * Get name
	 *
	 * @return string 
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set url
	 *
	 * @param string $url
	 * @return Fichier
	 */
	public function setUrl($url)
	{
		$this->url = $url;
	
		return $this;
	}

	/**
	 * Get url
	 *
	 * @return string 
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * Set dateAjout
	 *
	 * @param \DateTime $dateAjout
	 * @return Fichier
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
	 * Set documentheque
	 *
	 * @param \Kub\CollaborationBundle\Entity\Documentheque $documentheque
	 * @return Fichier
	 */
	public function setDocumentheque(\Kub\CollaborationBundle\Entity\Documentheque $documentheque = null)
	{
		$this->documentheque = $documentheque;
	
		return $this;
	}

	/**
	 * Get documentheque
	 *
	 * @return \Kub\CollaborationBundle\Entity\Documentheque 
	 */
	public function getDocumentheque()
	{
		return $this->documentheque;
	}
}