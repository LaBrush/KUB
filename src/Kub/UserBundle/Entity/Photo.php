<?php
namespace Kub\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Kub\HomeBundle\Entity\FIle ;

/**
 * @ORM\Table(name="eleve_photo")
 * @ORM\Entity(repositoryClass="Kub\UserBundle\Entity\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Photo extends File
{
	/**
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	public function getUploadDir()
	{
		// On retourne le chemin relatif vers l'image pour un navigateur
		return 'images/photos';
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