<?php

namespace EVN\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EVNHomeBundle:Default:index.html.twig');
    }
}
