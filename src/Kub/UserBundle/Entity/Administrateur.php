<?php

namespace Kub\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Administrateur
 *
 * @ORM\Entity
 * @ORM\Table()
 *
 */

class Administrateur extends User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function initClasse()
    {
        $this->classe = "administrateur";
    }

    public function __construct()
    {
        parent::__construct();
        $this->addRole("ROLE_ADMINISTRATEUR");
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
}