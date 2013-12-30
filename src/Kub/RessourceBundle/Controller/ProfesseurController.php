<?php

namespace Kub\RessourceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Kub\RessourceBundle\Entity\Ressource ;
use Kub\RessourceBundle\Form\Type\RessourceType ;
use Kub\RessourceBundle\Form\Handler\RessourceHandler ;

class ProfesseurController extends Controller
{
	/**
	 * @Secure(roles={"ROLE_PROFESSEUR"})
	 */
	public function validerAction()
	{
		return $this->render('KubRessourceBundle:Professeur:valider.html.twig');
	}
}
