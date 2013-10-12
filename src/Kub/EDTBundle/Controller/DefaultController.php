<?php

namespace Kub\EDTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('KubEDTBundle:Default:index.html.twig', array('name' => $name));
    }
}
