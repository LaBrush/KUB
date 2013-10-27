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
            $menu->addChild('Groupes', array("labelAttributes" => array("className" => "groupes")));
                $menu['Groupes']->addChild('Créer',
                    array(
                        'route' => 'groupe_create'
                    )
                );

            $menu->addChild('Eleves', array("labelAttributes" => array("className" => "eleve")));
                $menu['Eleves']->addChild('Liste', 
                    array(
                        'route' => 'user_list',
                        'routeParameters' => array('role' => 'eleve'),
                        ''
                    )
                );
                $menu['Eleves']->addChild('Créer', 
                    array(
                        'route' => 'user_create',
                        'routeParameters' => array('role' => 'eleve')
                    )
                );

            $menu->addChild('Professeurs', array("labelAttributes" => array("className" => "professeur")));
                $menu['Professeurs']->addChild('Liste', 
                    array(
                        'route' => 'user_list',
                        'routeParameters' => array('role' => 'professeur')
                    )
                );
                $menu['Professeurs']->addChild('Créer', 
                    array(
                        'route' => 'user_create',
                        'routeParameters' => array('role' => 'professeur')
                    )
                );

            $menu->addChild('Tuteurs', array("labelAttributes" => array("className" => "tuteur")));
                $menu['Tuteurs']->addChild('Liste', 
                    array(
                        'route' => 'user_list',
                        'routeParameters' => array('role' => 'tuteur')
                    )
                );
                $menu['Tuteurs']->addChild('Créer', 
                    array(
                        'route' => 'user_create',
                        'routeParameters' => array('role' => 'tuteur')
                    )
                );

            $menu->addChild('Administration', array("labelAttributes" => array("className" => "administrateur")));
                $menu['Administration']->addChild('Liste', 
                    array(
                        'route' => 'user_list',
                        'routeParameters' => array('role' => 'administrateur')
                    )
                );
                $menu['Administration']->addChild('Créer', 
                    array(
                        'route' => 'user_create',
                        'routeParameters' => array('role' => 'administrateur')
                    )
                );

            $menu->addChild('Emplois du temps', array("labelAttributes" => array("className" => "tuteur")));
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

        $menu->addChild('Mon compte', 
            array(
                'route' => 'fos_user_profile_show'
            )
        );

        //Penser à ajouter un discriminant
        $menu->addChild('Parametres',
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