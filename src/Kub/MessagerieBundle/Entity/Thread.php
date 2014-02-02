<?php

namespace Kub\MessagerieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Thread
 *
 * @ORM\Table
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
     * @ORM\OneToMany(targetEntity="Kub\MessagerieBundle\Entity\Message", mappedBy="thread", cascade={"persist", "merge", "detach"})
     * @OrderBy({"date" = "DESC"})
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

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_message", type="datetime")
     */
    private $dateLastMessage ;

    public function getAllUsers()
    {
        $users = $this->getUsers()->toArray();

        foreach ($this->getGroupes() as $groupe) {
            $users = array_merge($users, $groupe->getEleves()->toArray());
        }

        return array_unique($users, SORT_STRING);
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->groupes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dateLastMessage = new \DateTime ;
    }

    /**
     * Add messages
     *
     * @param \Kub\MessagerieBundle\Entity\Message $messages
     * @return Thread
     */
    public function addMessage(\Kub\MessagerieBundle\Entity\Message $messages)
    {
        $this->dateLastMessage = new \DateTime ;
        $this->messages[] = $messages;
    
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
     * Set dateLastMessage
     *
     * @param \DateTime $dateLastMessage
     * @return Thread
     */
    public function setDateLastMessage($dateLastMessage)
    {
        $this->dateLastMessage = $dateLastMessage;
    
        return $this;
    }

    /**
     * Get dateLastMessage
     *
     * @return \DateTime 
     */
    public function getDateLastMessage()
    {
        return $this->dateLastMessage;
    }
}