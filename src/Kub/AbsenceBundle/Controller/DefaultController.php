<?php

namespace Kub\AbsenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('KubAbsenceBundle:Default:index.html.twig', array('name' => $name));
    }
}
