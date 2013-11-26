<?php
namespace Kub\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Kub\HomeBundle\Entity\FIle ;

/**
 * @ORM\Table(name="Photo")
 * @ORM\Entity
 */
class Photo extends File
{
	public function getUploadDir()
	{
		// On retourne le chemin relatif vers l'image pour un navigateur
		return 'images/photos';
	}

	public function getWebPath()
	{
		if($this->id > 0)
		{
			return parent::getWebPath();
		}
		else
		{
			return $this->getUploadDir().'/0' . $this->url ;
		}
	}
}