<?php

namespace Kub\EDTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class EDTController extends Controller
{
	public function indexAction()
	{
		$user = $this->getUser();

		if(get_class( $user ) != "Kub\UserBundle\Entity\Eleve" && get_class( $user ) != "Kub\UserBundle\Entity\Professeur")
		{
			throw new AccessDeniedException("Vous n'avez pas d'emplois du temps. Ici.");
		}

		return $this->render('KubEDTBundle:User:show.html.twig'); 
	}
}
