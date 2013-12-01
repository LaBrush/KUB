<?php

namespace Kub\RessourceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FileRessource
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class FileRessource extends Ressource
{
    /**
     * @ORM\OneToOne(targetEntity="Kub\RessourceBundle\Entity\File", cascade={"all"})
     */
    private $file ;

    /**
     * Set file
     *
     * @param \Kub\RessourceBundle\Entity\File $file
     * @return FileRessource
     */
    public function setFile(\Kub\RessourceBundle\Entity\File $file = null)
    {
        $this->file = $file;
    
        return $this;
    }

    /**
     * Get file
     *
     * @return \Kub\RessourceBundle\Entity\File 
     */
    public function getFile()
    {
        return $this->file;
    }
}