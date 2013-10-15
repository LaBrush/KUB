<?php
// src/Acme/MainBundle/Menu/MenuBuilder.php

namespace Kub\UserBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class MenuBuilder
{
    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Home', array('route' => 'home_homepage'));
        $menu->addChild('Eleves');
            $menu["Eleves"]->addChild("Liste", 
                array(
                    "route" => "user_list_role",
                    'routeParameters' => array('role' => "eleve")
                )
            );
            $menu["Eleves"]->addChild("Créer", 
                array(
                    "route" => "user_create",
                    'routeParameters' => array('role' => "eleve")
                )
            );

        $menu->addChild('Professeurs');
            $menu["Professeurs"]->addChild("Liste", 
                array(
                    "route" => "user_list_role",
                    'routeParameters' => array('role' => "professeur")
                )
            );
            $menu["Professeurs"]->addChild("Créer", 
                array(
                    "route" => "user_create",
                    'routeParameters' => array('role' => "professeur")
                )
            );

        $menu->addChild('Tuteur');
            $menu["Tuteur"]->addChild("Liste", 
                array(
                    "route" => "user_list_role",
                    'routeParameters' => array('role' => "tuteur")
                )
            );
            $menu["Tuteur"]->addChild("Créer", 
                array(
                    "route" => "user_create",
                    'routeParameters' => array('role' => "tuteur")
                )
            );

        $menu->addChild('Administration');
            $menu["Administration"]->addChild("Liste", 
                array(
                    "route" => "user_list_role",
                    'routeParameters' => array('role' => "administrateur")
                )
            );
            $menu["Administration"]->addChild("Créer", 
                array(
                    "route" => "user_create",
                    'routeParameters' => array('role' => "administrateur")
                )
            );

        $menu->addChild('Mon compte', 
            array(
                "route" => "fos_user_profile_show"
            )
        );

        //Penser à ajouter un discriminateur
        // $menu->addChild('Parametres', 
        //     array(
        //         "route" => "fos_user_profile_edit"
        //     )
        // );

        return $menu;
    }
}