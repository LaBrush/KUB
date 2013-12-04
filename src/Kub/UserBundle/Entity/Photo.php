<?php
namespace Kub\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Kub\HomeBundle\Entity\File as BaseFile ;

/**
 * @ORM\Table(name="Photo")
 * @ORM\Entity
 */
class Photo extends BaseFile
{
	 /**
     * @Assert\Image(
     *     minWidth = 100,
     *     maxWidth = 400,
     *     minHeight = 100,
     *     maxHeight = 400
     * )
     */
	protected $file ;

	public function getUploadDir()
	{
		// On retourne le chemin relatif vers l'image pour un navigateur
		return 'images/photos';
	}

	public function getWebPath()
	{
		if($this->getId() > 0)
		{
			return parent::getWebPath();
		}
		else
		{
			return $this->getUploadDir().'/0' . $this->url ;
		}
	}
}