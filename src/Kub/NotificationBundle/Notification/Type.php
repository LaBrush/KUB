<?php

namespace Kub\NotificationBundle\Notification;

abstract class Type
{
    private $path ;
    private $titre ;
    private $explication ;

    public function __construct($titre, $path, $explicationSchema)
    {
        $this->titre = $titre ;
        $this->path = $path ;

        $this->explicationSchema = $explicationSchema ;
        $this->explication = "";
    }

    public function formatExplication(array $arguments)
    {
        $this->explication = preg_replace("{{ (\w+) }}", $arguments[$1] $this->explicationSchema ;
    }

    public function getTitre()
    {
        return $this->titre;
    }     

    public function getPath()
    {
        return $this->path;
    }

    public function getExplication()
    {
        return $this->explication ;
    }
}
