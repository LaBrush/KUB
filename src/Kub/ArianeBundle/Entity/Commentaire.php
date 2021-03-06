<?php

namespace Kub\ArianeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;

/**
 * @ORM\Entity
 * @ORM\Table(name="ariane_commentaire")
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
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Kub\ArianeBundle\Entity\Post", inversedBy="commentaires", cascade={"persist", "merge"})
     */
    protected $post;

    /**
     * @ORM\ManyToOne(targetEntity="Kub\UserBundle\Entity\User")
     */
    protected $auteur;

    /**
     * @ORM\Column(name="contenu", type="text")
     * @Assert\NotNull()
     */
    protected $contenu;

    /**
     * @ORM\Column(name="date", type="datetime")
     */
    protected $date ;

    /**
     * @ORM\OneToOne(targetEntity="Kub\NotificationBundle\Entity\ArianeCommentaireNotification", inversedBy="commentaire",  cascade={"all"})
     */
    private $notification ;

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
     * Set post
     *
     * @param \Kub\ArianeBundle\Entity\Post $post
     * @return Commentaire
     */
    public function setPost(\Kub\ArianeBundle\Entity\Post $post = null)
    {
        $this->post = $post;
    
        return $this;
    }

    /**
     * Get post
     *
     * @return \Kub\ArianeBundle\Entity\Post 
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Commentaire
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
     * Set auteur
     *
     * @param \Kub\UserBundle\Entity\User $auteur
     * @return Commentaire
     */
    public function setAuteur(\Kub\UserBundle\Entity\User $auteur = null)
    {
        $this->auteur = $auteur;
    
        return $this;
    }

    /**
     * Get auteur
     *
     * @return \Kub\UserBundle\Entity\User 
     */
    public function getAuteur()
    {
        return $this->auteur;
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


    /**
     * Set notification
     *
     * @param \Kub\NotificationBundle\Entity\ArianeCommentaireNotification $notification
     * @return Commentaire
     */
    public function setNotification(\Kub\NotificationBundle\Entity\ArianeCommentaireNotification $notification = null)
    {
        $this->notification = $notification;
    
        return $this;
    }

    /**
     * Get notification
     *
     * @return \Kub\NotificationBundle\Entity\ArianeCommentaireNotification 
     */
    public function getNotification()
    {
        return $this->notification;
    }
}