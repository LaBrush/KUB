<?php

namespace Kub\EDTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class EDTController extends Controller
{
	public function indexAction()
	{
		$edt = 1 ;
		$user = $this->getUser();

		switch(get_class( $user ))
		{
			case "Kub\UserBundle\Entity\Eleve": 
			case "Kub\UserBundle\Entity\Professeur": 
				// $edt = $this->get('kub.edt.time')->getEDTOf( $user );
				$edt = $this->get('kub.edt.time')->getEDTOf( $user );
				break;
			default: 
				throw new \AccessDeniedException("Vous n'avez pas d'emplois du temps. Ici.");
				break;
		}

		return $this->render('KubEDTBundle:EDT:show.html.twig',
            array(
            	"edt" => $edt
            )
        ); 
	}
}
