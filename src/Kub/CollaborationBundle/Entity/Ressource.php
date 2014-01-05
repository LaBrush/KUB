<?php
namespace Kub\CollaborationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Kub\HomeBundle\Entity\Ressource as BaseRessource ;

/**
 * Ressource
 *
 * @ORM\Table(name="collaboration_Ressource")
 * @ORM\Entity()
 */
class Ressource extends BaseRessource 
{
    /**
     * @ORM\OneToOne(targetEntity="Kub\CollaborationBundle\Entity\File", cascade={"all"})
     */
    private $file ;

	/**
     * @ORM\ManyToOne(targetEntity="Kub\CollaborationBundle\Entity\Documentheque", inversedBy="ressources")
     */
    private $documentheque ;

    /**
     * Set documentheque
     *
     * @param \Kub\CollaborationBundle\Entity\Documentheque $documentheque
     * @return Ressource
     */
    public function setDocumentheque(\Kub\CollaborationBundle\Entity\Documentheque $documentheque = null)
    {
        $this->documentheque = $documentheque;
    
        return $this;
    }

    /**
     * Get documentheque
     *
     * @return \Kub\CollaborationBundle\Entity\Documentheque 
     */
    public function getDocumentheque()
    {
        return $this->documentheque;
    }

    /**
     * Set file
     *
     * @param \Kub\CollaborationBundle\Entity\File $file
     * @return Ressource
     */
    public function setFile(\Kub\CollaborationBundle\Entity\File $file = null)
    {
        $this->file = $file;
    
        return $this;
    }

    /**
     * Get file
     *
     * @return \Kub\CollaborationBundle\Entity\File 
     */
    public function getFile()
    {
        return $this->file;
    }
}