<?php

namespace Kub\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser ;
use Gedmo\Mapping\Annotation as Gedmo;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert ;


/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"eleve" = "Eleve", "tuteur" = "Tuteur", "professeur" = "Professeur", "administrateur" = "Administrateur"})
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="username", column=@ORM\Column(length=128, unique=true, nullable=false))
 * }) 
 *
 * @UniqueEntity(fields = "email", targetClass = "Kub\UserBundle\Entity\User", message="fos_user.email.already_used")
 */
abstract class User extends BaseUser
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
     * @var string
     *
     * @Gedmo\Slug(fields={"prenom", "nom"})
     */
    protected $username ;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"prenom", "nom"})
     */
    protected $usernameCanonical ;    

    /**
     * @Assert\Email(message="L'adresse e-mail est invalide")
     * @Assert\NotBlank()
     */
    protected $email ;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="3", minMessage="Le nom doit faire au moins {{ limit }} caractères")
     */
    private $nom ;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="3", minMessage="Le prénom doit faire au moins {{ limit }} caractères")
     */ 
    private $prenom;

    public function __construct()
    {
        parent::__construct();
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
     * Set string
     *
     * @param string $string
     * @return User
     */
    public function setString($string)
    {
        $this->string = $string;
    
        return $this;
    }

    /**
     * Get string
     *
     * @return string 
     */
    public function getString()
    {
        return $this->string;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        $this->updateUsername() ;
    
        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
        $this->updateUsername();

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    public function updateUsername()
    {
        $this->username = strtolower($this->prenom) . strtolower($this->nom);
    }
}