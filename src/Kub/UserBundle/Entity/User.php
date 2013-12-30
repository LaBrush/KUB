<?php

namespace Kub\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert ;

use FOS\UserBundle\Model\User as BaseUser ;
use FOS\MessageBundle\Model\ParticipantInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"eleve" = "Eleve", "tuteur" = "Tuteur", "professeur" = "Professeur", "administrateur" = "Administrateur"})
 *
 * @UniqueEntity(fields = "email", targetClass = "Kub\UserBundle\Entity\User", message="fos_user.email.already_used")
 * 
 * @ORM\HasLifecycleCallbacks()
 *
 * @ORM\Entity(repositoryClass="Kub\UserBundle\Entity\UserRepository")
 */

abstract class User extends BaseUser implements ParticipantInterface
{

    /**
     * @ORM\PostLoad
     */
    public function initClass() {}

    /**
     * @ORM\PrePersist()
     */
    public function initPassword(){ 
        if($this->password == "")
        {
            $this->setPassword(sha1(uniqid()));
        }
    }

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

    protected $class ;
    public function __construct()
    {
        parent::__construct();
        $this->initClass();
    }

    public function getClass()
    {
        return $this->class ;
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

    public function __toString()
    {
        return $this->prenom . " " . $this->nom ;
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
        $this->username = str_replace(
            array(
                'à', 'â', 'ä', 'á', 'ã', 'å',
                'î', 'ï', 'ì', 'í', 
                'ô', 'ö', 'ò', 'ó', 'õ', 'ø', 
                'ù', 'û', 'ü', 'ú', 
                'é', 'è', 'ê', 'ë',
                'ç', 'ÿ', 'ñ', ' '
            ),
            array(
                'a', 'a', 'a', 'a', 'a', 'a', 
                'i', 'i', 'i', 'i', 
                'o', 'o', 'o', 'o', 'o', 'o', 
                'u', 'u', 'u', 'u', 
                'e', 'e', 'e', 'e', 
                'c', 'y', 'n', ''
            ),
            $this->username
        );
    }
}