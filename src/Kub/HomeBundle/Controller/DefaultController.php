<?php

namespace Kub\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('KubHomeBundle:Default:index.html.twig');
    }
}
