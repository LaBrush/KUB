<?php
namespace Kub\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Kub\HomeBundle\Entity\File ;

/**
 * @ORM\Table(name="collaboration_file")
 * @ORM\HasLifecycleCallbacks
 */
class Fichier extends File
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
		return 'collaboration';
	}

}