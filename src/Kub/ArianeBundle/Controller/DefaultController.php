<?php

namespace Kub\ArianeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $security = $this->get('security.context');

        return $this->render('KubArianeBundle:Eleve:home.html.twig');

    }
}
