<?php

namespace Kub\MessagerieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="messages")
 * @ORM\Entity
 */
class Message
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Kub\MessagerieBundle\Entity\Thread", inversedBy="messages", cascade={"all"})
     */
    private $thread ;

    /**
     * @ORM\OneToMany(targetEntity="MessageUser", mappedBy="message", cascade={"persist"})
     */
    private $messageUser ;

    /**
     * @ORM\ManyToOne(targetEntity="Kub\UserBundle\Entity\User")
     */
    private $sender ;

    public function __toString()
    {
        return $this->getSender() . ' : ' . $this->contenu ;
    }

    public function __construct(){

        $this->date = new \DateTime ;
        $this->messageUser = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Message
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
     * Set date
     *
     * @param \DateTime $date
     * @return Message
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
     * Set thread
     *
     * @param \Kub\MessagerieBundle\Entity\Thread $thread
     * @return Message
     */
    public function setThread(\Kub\MessagerieBundle\Entity\Thread $thread = null)
    {
        $this->thread = $thread;
    
        return $this;
    }

    /**
     * Get thread
     *
     * @return \Kub\MessagerieBundle\Entity\Thread 
     */
    public function getThread()
    {
        return $this->thread;
    }
    
    /**
     * Add messageUser
     *
     * @param \Kub\MessagerieBundle\Entity\MessageUser $messageUser
     * @return Message
     */
    public function addMessageUser(\Kub\MessagerieBundle\Entity\MessageUser $messageUser)
    {
        $this->messageUser[] = $messageUser;
    
        return $this;
    }

    /**
     * Remove messageUser
     *
     * @param \Kub\MessagerieBundle\Entity\MessageUser $messageUser
     */
    public function removeMessageUser(\Kub\MessagerieBundle\Entity\MessageUser $messageUser)
    {
        $this->messageUser->removeElement($messageUser);
    }

    /**
     * Get messageUser
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMessageUser()
    {
        return $this->messageUser;
    }

    /**
     * Set sender
     *
     * @param \Kub\UserBundle\Entity\User $sender
     * @return Message
     */
    public function setSender(\Kub\UserBundle\Entity\User $sender = null)
    {
        $this->sender = $sender;
    
        return $this;
    }

    /**
     * Get sender
     *
     * @return \Kub\UserBundle\Entity\User 
     */
    public function getSender()
    {
        return $this->sender;
    }
}