<?php
namespace Kub\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Kub\HomeBundle\Entity\File as BaseFile ;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="Photo")
 * @ORM\Entity
 * @Gedmo\Uploadable(path="/photos", filenameGenerator="SHA1", allowOverwrite=true, appendNumber=true)
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
		if($this->getUrl() != '')
		{			
			return parent::getWebPath();
		}
		else
		{
			return $this->getUploadDir().'/0.png' ;
		}
	}

}