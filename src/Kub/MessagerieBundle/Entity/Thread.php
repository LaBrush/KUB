<?php

namespace Kub\MessagerieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Thread
 *
 * @ORM\Table(name="threads")
 * @ORM\Entity(repositoryClass="Kub\MessagerieBundle\Entity\ThreadRepository")
 */
class Thread
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
     * @ORM\Column(name="lastMessage", type="datetime", nullable=true)
     */
    private $lastMessage;

    /**
     * @ORM\OneToMany(targetEntity="Kub\MessagerieBundle\Entity\Message", mappedBy="thread", cascade={"persist", "merge", "detach"})
     */
    private $messages ;

    /**
     * @ORM\ManyToMany(targetEntity="Kub\UserBundle\Entity\User")
     */
    private $users ;

    /**
     * @ORM\ManyToMany(targetEntity="Kub\ClasseBundle\Entity\Groupe")
     */
    private $groupes ;

    public function getAllUsers()
    {
        $users = $this->getUsers()->toArray();

        foreach ($this->getGroupes() as $groupe) {
            $users = array_merge($users, $groupe->getEleves()->toArray());
        }

        return array_unique($users, SORT_STRING);
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
     * Set lastMessage
     *
     * @param \DateTime $lastMessage
     * @return Thread
     */
    public function setLastMessage($lastMessage)
    {
        $this->lastMessage = $lastMessage;
    
        return $this;
    }

    /**
     * Get lastMessage
     *
     * @return \DateTime 
     */
    public function getLastMessage()
    {
        return $this->lastMessage;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->groupes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add messages
     *
     * @param \Kub\MessagerieBundle\Entity\Message $messages
     * @return Thread
     */
    public function addMessage(\Kub\MessagerieBundle\Entity\Message $messages)
    {
        $this->messages[] = $messages;
        $this->setLastMessage( new \DateTime );
    
        return $this;
    }

    /**
     * Remove messages
     *
     * @param \Kub\MessagerieBundle\Entity\Message $messages
     */
    public function removeMessage(\Kub\MessagerieBundle\Entity\Message $messages)
    {
        $this->messages->removeElement($messages);
    }

    /**
     * Get messages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Add users
     *
     * @param \Kub\UserBundle\Entity\User $users
     * @return Thread
     */
    public function addUser(\Kub\UserBundle\Entity\User $users)
    {
        if(!$this->users->contains($users))
        {
            $this->users[] = $users;
        }
    
        return $this;
    }

    /**
     * Remove users
     *
     * @param \Kub\UserBundle\Entity\User $users
     */
    public function removeUser(\Kub\UserBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add groupes
     *
     * @param \Kub\ClasseBundle\Entity\Groupe $groupes
     * @return Thread
     */
    public function addGroupe(\Kub\ClasseBundle\Entity\Groupe $groupes)
    {
        if(!$this->groupes->contains($groupes))
        {
            $this->groupes[] = $groupes;
        }
    
        return $this;
    }

    /**
     * Remove groupes
     *
     * @param \Kub\ClasseBundle\Entity\Groupe $groupes
     */
    public function removeGroupe(\Kub\ClasseBundle\Entity\Groupe $groupes)
    {
        $this->groupes->removeElement($groupes);
    }

    /**
     * Get groupes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroupes()
    {
        return $this->groupes;
    }
}