<?php
namespace Kub\ArianeBundle\Form\Manager ;

use Kub\ArianeBundle\Entity\Post ;
use Kub\ArianeBundle\Form\Type\PostType ;
use Kub\ArianeBundle\Form\Handler\PostHandler ;

class FormManager
{
	private $request ;
	private $em ;
	private $security ;
	private $formFactory ;
	private $session ;

	public function __construct($request, $em, $security, $formFactory, $session)
	{
		$this->request = $request ;
		$this->em = $em ;
		$this->security = $security ;
		$this->formFactory = $formFactory ;
		$this->session = $session ;
	}

	public function manageCreateForm()
	{
		$post = new Post ;
        $form = $this->formFactory->create(new PostType, $post);

		$fil = $this->security->getToken()->getUser()->getFil();

		if($this->request->getMethod() == "POST"){

			$formHandler = new PostHandler($form, $this->request, $this->em, $fil);

			if($formHandler->process())
			{
				$this->session->getFlashBag()->add('info', "Le post a bien été ajouté");
			}
			else
			{
				$this->session->getFlashBag()->add('info', "Erreur lors de l'ajout de la trace"); 
			}

		}

		return $form->createView() ;
	}
}