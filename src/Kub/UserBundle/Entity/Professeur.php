<?php

namespace Kub\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Professeur
 *
 * @ORM\Entity
 * @ORM\Table()
 */

class Professeur extends User
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
        $this->classe = "professeur";
    }

    public function __construct()
    {
        parent::__construct();

        $this->addRole("ROLE_PROFESSEUR");
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