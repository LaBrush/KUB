<?php

namespace Kub\MessagerieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MessageUser
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class MessageUser
{

    /**
     * @var boolean
     *
     * @ORM\Column(name="readed", type="boolean")
     */
    private $readed;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Kub\MessagerieBundle\Entity\Message", inversedBy="messageUser")
     */
    private $message ;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Kub\UserBundle\Entity\User")
     */
    private $user ;

    public function __construct()
    {
        $this->readed = false ;
    }

    /**
     * Set readed
     *
     * @param boolean $readed
     * @return MessageUser
     */
    public function setReaded($readed)
    {
        $this->readed = $readed;
    
        return $this;
    }

    /**
     * Get readed
     *
     * @return boolean 
     */
    public function getReaded()
    {
        return $this->readed;
    }

    /**
     * Set message
     *
     * @param \Kub\MessagerieBundle\Entity\Message $message
     * @return MessageUser
     */
    public function setMessage(\Kub\MessagerieBundle\Entity\Message $message)
    {
        $this->message = $message;
    
        return $this;
    }

    /**
     * Get message
     *
     * @return \Kub\MessagerieBundle\Entity\Message 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set user
     *
     * @param \Kub\UserBundle\Entity\User $user
     * @return MessageUser
     */
    public function setUser(\Kub\UserBundle\Entity\User $user)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Kub\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}