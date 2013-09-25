<?php

namespace Kub\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	$user = $this->getUser();

    	if($this->getUser())
    	{
    		$security = $this->get('security.context');

    		if($security->isGranted("ROLE_ELEVE"))
    		{
    			return $this->render("KubHomeBundle:Eleve:index.html.twig");
    		}
    		else
    		{
    			throw new \Exception("coucou");	
    		}
    	}
    	else
    	{
    		return $this->render("KubHomeBundle:Visiteur:index.html.twig");
    	}

    }

    public function showEleveAction()
    {

    }
}
