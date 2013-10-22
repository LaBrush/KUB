<?php

namespace Kub\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Kub\UserBundle\Entity\Groupe;
use Kub\UserBundle\Form\Type\GroupeType ;
use Kub\UserBundle\Form\Handler\GroupeHandler ;

/**
 * Groupe controller.
 *
 */
class GroupeController extends Controller
{

    /**
     * @Secure(roles="ROLE_SECRETAIRE")
     */
    public function createAction()
    {
        $groupe = new Groupe ;
        $form = $this->createForm(new GroupeType, $groupe);

        $request = $this->get('request');
        $em = $this->getDoctrine()->getManager();

        if($request->getMethod() == "POST"){

            $formHandler = new GroupeHandler($form, $request, $this->getDoctrine()->getManager());

            if($formHandler->process())
            {
                $this->get('session')->getFlashBag()->add('info', "Le groupe a bien été ajouté");
                return $this->redirect($this->generateUrl("home_homepage"));
            }

        }

        return $this->render('KubUserBundle:Groupe:create.html.twig',
            array(
                'form' => $form->createView(),
                'groupe' => $groupe
            )
        );
    }

    /**
     * @Secure(roles="ROLE_SECRETAIRE")
     */
    public function editAction()
    {
        
    }

    /**
     * @Secure(roles="ROLE_USER")
     */

    public function listAction()
    {
        
    }

    /**
     * @Secure(roles="ROLE_USER")
     */

    public function showAction()
    {

    }

}
