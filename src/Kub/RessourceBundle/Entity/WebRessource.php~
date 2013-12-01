<?php

namespace Kub\RessourceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WebRessource
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class WebRessource extends Ressource
{
    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * Set url
     *
     * @param string $url
     * @return WebRessource
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }
}