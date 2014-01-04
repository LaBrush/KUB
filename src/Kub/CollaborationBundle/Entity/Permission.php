<?php

namespace Kub\CollaborationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Permission
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Permission
{
    const VISITEUR = 1 ;
    const CONTRIBUTEUR = 2 ;
    const ADMINISTRATEUR = 3 ;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", name="role")
     */
    private $role ;

    /**
     * @ORM\ManyToOne(targetEntity="Kub\CollaborationBundle\Entity\Projet", inversedBy="permissions", cascade={"persist"})
     */
    private $projet ;

    /**
     * @ORM\ManyToOne(targetEntity="Kub\UserBundle\Entity\User", cascade={"persist"})
     */
    private $user ;

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
     * Set projet
     *
     * @param \Kub\CollaborationBundle\Entity\Projet $projet
     * @return Permission
     */
    public function setProjet(\Kub\CollaborationBundle\Entity\Projet $projet = null)
    {
        $this->projet = $projet;
    
        return $this;
    }

    /**
     * Get projet
     *
     * @return \Kub\CollaborationBundle\Entity\Projet 
     */
    public function getProjet()
    {
        return $this->projet;
    }

    /**
     * Set user
     *
     * @param \Kub\UserBundle\Entity\User $user
     * @return Permission
     */
    public function setUser(\Kub\UserBundle\Entity\User $user = null)
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

    /**
     * Set role
     *
     * @param integer $role
     * @return Permission
     */
    public function setRole($role)
    {
        $this->role = $role;
    
        return $this;
    }

    /**
     * Get role
     *
     * @return integer 
     */
    public function getRole()
    {
        return $this->role;
    }
}