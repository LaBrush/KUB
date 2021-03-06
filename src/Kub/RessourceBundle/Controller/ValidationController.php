<?php

namespace Kub\RessourceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Kub\RessourceBundle\Entity\Ressource ;
use Kub\RessourceBundle\Form\Type\RessourceType ;
use Kub\RessourceBundle\Form\Handler\RessourceHandler ;

class ValidationController extends Controller
{
	/**
	 * @Secure(roles={"ROLE_PROFESSEUR"})
	 */
	public function indexAction()
	{
		$ressources = $this->get('doctrine.orm.default_entity_manager')->getRepository("KubRessourceBundle:Ressource")->findByValide(false);
		return $this->render('KubRessourceBundle:Valider:list.html.twig', array('ressources' => $ressources));
	}

	/**
	 * @Secure(roles={"ROLE_PROFESSEUR"})
	 */
	public function validerAction(Ressource $ressource)
	{
		$em = $this->get('doctrine.orm.default_entity_manager');

		$form = $this->createFormBuilder(null, array(
			"action" => $this->generateUrl("kub_ressource_validation_valider", array('id' => $ressource->getId()))
		))->getForm();
		$request = $this->getRequest();

		if ($request->getMethod() == 'POST') {
			$form->bind($request);

			if ($form->isValid()) {

				$ressource->setValide(true);
				$em->persist($ressource);
				$em->flush();

				$this->get('session')->getFlashBag()->add('info', 'La ressource a bien été validée');
			}

			return $this->redirect($this->generateUrl('kub_ressource_validation_list'));
		}


		return $this->render('KubRessourceBundle:Valider:valider_content.html.twig', array(
			'form' => $form->createView(),
			'ressource' => $ressource
		));
	}
}
