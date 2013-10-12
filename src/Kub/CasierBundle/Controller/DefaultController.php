<?php

namespace Kub\CasierBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('KubCasierBundle:Default:index.html.twig', array('name' => $name));
    }
}
