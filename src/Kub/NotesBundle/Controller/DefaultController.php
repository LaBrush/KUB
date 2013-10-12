<?php

namespace Kub\NotesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('KubNotesBundle:Default:index.html.twig', array('name' => $name));
    }
}
