<?php
// src/Acme/MainBundle/Menu/MenuBuilder.php

namespace Kub\UserBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext ;

class MenuBuilder
{
    private $factory;
    private $security;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory, SecurityContext $security)
    {
        $this->factory = $factory;
        $this->security = $security ;
    }

    public function createMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Accueil', array('route' => 'home_homepage', "labelAttributes" => array("className" => "accueil")));
            
        if($this->security->isGranted('ROLE_SECRETAIRE'))
        {
            $menu->addChild('Utilisateurs', array("labelAttributes" => array("className" => "utilisateurs")));
                $menu['Utilisateurs']->addChild('Eleves', 
                    array(
                        'route' => 'user_list',
                        'routeParameters' => array('role' => 'eleve'),
                        ''
                    )
                );
                $menu['Utilisateurs']->addChild('Professeurs', 
                    array(
                        'route' => 'user_list',
                        'routeParameters' => array('role' => 'professeur')
                    )
                );
                $menu['Utilisateurs']->addChild('Tuteurs', 
                    array(
                        'route' => 'user_list',
                        'routeParameters' => array('role' => 'tuteur')
                    )
                );
                $menu['Utilisateurs']->addChild('Administration', 
                    array(
                        'route' => 'user_list',
                        'routeParameters' => array('role' => 'administrateur')
                    )
                );

            $menu->addChild('Groupes', array("labelAttributes" => array("className" => "groupes")));
                $menu['Groupes']->addChild('Liste',
                    array(
                        'route' => 'groupe_list'
                    )
                );

            $menu->addChild('Emplois du temps', array("labelAttributes" => array("className" => "tuteur")));
                $menu['Emplois du temps']->addChild('Frequences',
                    array(
                        'route' => 'frequence_list'
                    )
                );

            $menu->addChild('Emplois du temps', array("labelAttributes" => array("className" => "agenda")));
                $menu['Emplois du temps']->addChild('Fréquences',
                    array(
                        'route' => 'frequence_list'
                    )
                );
                $menu['Emplois du temps']->addChild('Cours',
                    array(
                        'route' => 'cours_list'
                    )
                );

        }

        foreach ($menu as $key => $categorie) {
            if($categorie->getUri() == "" && count($categorie->getChildren()) > 0)
            {
                foreach ($categorie->getChildren() as $key => $child) {
                    $categorie->setUri($child->getUri());
                    break ;
                }
            }
        }

        return $menu;
    }

    public function createCompteMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');

        //Penser à ajouter un discriminant
        $menu->addChild('Mon compte',
            array(
                'route' => 'fos_user_profile_edit'
            )
        );

        $menu->addChild('Me déconnecter', 
            array(
                'route' => 'fos_user_security_logout'
            )
        );

        return $menu;
    }
}