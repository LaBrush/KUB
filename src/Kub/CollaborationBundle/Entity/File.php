<?php
namespace Kub\CollaborationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Kub\HomeBundle\Entity\File as BaseFile ;

/**
 * @ORM\Table(name="collaboration_file")
 * @ORM\Entity
 */
class File extends BaseFile
{
	public function getUploadDir()
	{
		// On retourne le chemin relatif vers l'image pour un navigateur
		return 'uploads/collaboration';
	}
}