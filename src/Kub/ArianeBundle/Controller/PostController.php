<?php

namespace Kub\ArianeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Kub\ArianeBundle\Entity\Post ;
use Kub\ArianeBundle\Entity\Fil  ;

use Kub\ArianeBundle\Form\Type\PostType ;
use Kub\ArianeBundle\Form\Handler\PostHandler ;

class PostController extends Controller
{
    /**
     * @Secure(roles="ROLE_ELEVE")
     */
    public function addAction()
    {
        $post = new Post ;
        $form = $this->createForm(new PostType, $post);

        $request = $this->get('request');
        $em = $this->getDoctrine()->getManager();

        $fil = $this->getUser()->getFil();

        if($request->getMethod() == "POST"){

            $formHandler = new PostHandler($form, $request, $this->getDoctrine()->getManager(), $fil);

            if($formHandler->process())
            {
                $this->get('session')->getFlashBag()->add('info', "Le post a bien été ajouté");
                return $this->redirect($this->generateUrl("ariane_homepage"));
            }

        }

        return $this->render('KubArianeBundle:Post:create.html.twig',
            array(
                'form' => $form->createView(),
            )
        );   
    }

    /**
     * @Secure(roles="ROLE_ELEVE")
     */
    public function editAction(Post $post)
    {
        $form = $this->createForm(new PostType, $post);

        $request = $this->get('request');
        $em = $this->getDoctrine()->getManager();

        $fil = $this->getUser()->getFil();

        if($request->getMethod() == "POST"){

            $formHandler = new PostHandler($form, $request, $this->getDoctrine()->getManager(), $fil);

            if($formHandler->process())
            {
                $this->get('session')->getFlashBag()->add('info', "Le post a bien été modifié");
                return $this->redirect($this->generateUrl("ariane_homepage"));
            }

        }

        return $this->render('KubArianeBundle:Post:edit.html.twig',
            array(
                'form' => $form->createView(),
            )
        );   
    }

    /**
     * @Secure(roles="ROLE_ELEVE")
     */
    public function deleteAction(Post $post)
    {
        $form = $this->createFormBuilder()->getForm();
        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->remove($post);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'Trace bien supprimée');
    
                return $this->redirect($this->generateUrl('ariane_homepage'));
            }
        }

        return $this->render('KubArianeBundle:Post:delete.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
