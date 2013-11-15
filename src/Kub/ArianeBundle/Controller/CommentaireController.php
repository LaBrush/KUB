<?php

namespace Kub\ArianeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Kub\ArianeBundle\Entity\Commentaire ;
use Kub\ArianeBundle\Entity\Fil  ;

use Kub\ArianeBundle\Form\Type\CommentaireType ;
use Kub\ArianeBundle\Form\Handler\CommentaireHandler ;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CommentaireController extends Controller
{
    //Afin de savoir si l'utilisateur courant est autorisé à déposer des commentaires
    public function checkIfTokenAllowed($fil)
    {
        $security = $this->get('security.context');

        $allowed = false ;
        if($security->isGranted('ROLE_ELEVE'))
        {
            $allowed = true ;
        }
        else if($security->isGranted('ROLE_PROFESSEUR'))
        {
            if($security->getToken()->getUser()->hasEleve($fil->getEleve()))
            {
                $allowed = true;
            }
        }

        if(!$allowed)
        {
            throw new AccessDeniedException("Vous n'êtes pas autorisé à commenter ce fil");
        }
    }

    public function addAction(Fil $fil)
    {
        $this->checkIfTokenAllowed($fil);

        $commentaire = new Commentaire ;
        $commentaire->setAuteur($this->getUser());

        $form = $this->createForm(new CommentaireType, $commentaire);

        $request = $this->get('request');
        $em = $this->getDoctrine()->getManager();

        if($request->getMethod() == "POST"){

            $formHandler = new CommentaireHandler($form, $request, $this->getDoctrine()->getManager(), $this->getUser());

            $handler_response = $formHandler->process();
            // si le handler response n'est pas un booléen, alors c'est une liste d'erreurs du formulaire
            if($handler_response !== true)
            {
                $response = new Response($handler_response, 400) ;
                return $response ;   
            }

        }

        return $this->render('KubArianeBundle:Commentaire:create.html.twig',
            array(
                'form' => $form->createView(),
            )
        );   
    }

    public function deleteAction(Fil $fil, Commentaire $commentaire)
    {
        $response = new Response();

        $this->checkIfTokenAllowed($fil);

        $form = $this->createFormBuilder()->getForm();
        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->remove($commentaire);
                $em->flush();
        
                $response->setStatusCode(200);
            }
        }

        $response->setStatusCode(400);
        return $response ;
    }
}
