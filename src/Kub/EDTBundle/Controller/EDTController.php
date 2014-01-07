<?php

namespace Kub\EDTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Kub\UserBundle\Entity\Eleve ;
use Kub\UserBundle\Entity\Professeur ;

class EDTController extends Controller
{
	public function indexAction()
	{
		$user = $this->getUser();

		if(!($user instanceof Eleve) && !($user instanceof Professeur))
		{
			throw new AccessDeniedException("Vous n'avez pas d'emplois du temps. Ici.");
		}

		return $this->render('KubEDTBundle:User:show.html.twig'); 
	}
}
