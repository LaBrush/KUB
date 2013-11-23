<?php
// src/Acme/MainBundle/Menu/MenuBuilder.php

namespace Kub\UserBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext ;
use Doctrine\ORM\EntityManager ;
use FOS\MessageBundle\Provider\ProviderInterface as MessageProviderInterface;


class MenuBuilder
{
	private $factory;
	private $security;
	private $em; 
	private $messages;

	/**
	 * @param FactoryInterface $factory
	 */
	public function __construct(FactoryInterface $factory, SecurityContext $security, EntityManager $em, MessageProviderInterface $messages)
	{
		$this->factory = $factory;
		$this->security = $security ;
		$this->em = $em ;
		$this->messages = $messages ;
	}

	public function createMainMenu(Request $request)
	{
		$menu = $this->factory->createItem('root');

		$menu->addChild('Accueil', array('route' => 'home_homepage', 'labelAttributes' => array('className' => 'accueil')));
			
		$this->generateMessagesMenu($menu);

		if($this->security->isGranted('ROLE_SECRETAIRE'))
		{
			$this->generateSecretaireMenu($menu);   
		}
		else if($this->security->isGranted('ROLE_ELEVE'))
		{
			$this->generateEleveMenu($menu);
		}
		else if($this->security->isGranted('ROLE_PROFESSEUR'))
		{
			$this->generateProfesseurMenu($menu);
		}

		foreach ($menu as $key => $categorie) {
			if($categorie->getUri() == '' && count($categorie->getChildren()) > 0)
			{
				foreach ($categorie->getChildren() as $key => $child) {
					$categorie->setUri($child->getUri());
					break ;
				}
			}
		}

		return $menu;
	}

	public function generateMessagesMenu($menu)
	{
		$text = 'Mes messages'; $nb_unread = $this->messages->getNbUnreadMessages();

		if($nb_unread){
			$text .= '<span class="number">' . $nb_unread . '</span>';
		}

		$menu->addChild($text, array('route' => 'fos_message_inbox', 'labelAttributes' => array('className' => 'messagerie')));
	}

	public function generateSecretaireMenu($menu)
	{
		$menu->addChild('Utilisateurs', array('labelAttributes' => array('className' => 'utilisateurs')));
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

		$menu->addChild('Groupes', array('labelAttributes' => array('className' => 'groupes')));
			$menu['Groupes']->addChild('Liste',
				array(
					'route' => 'groupe_list'
				)
			);

		$menu->addChild('Emplois du temps', array('labelAttributes' => array('className' => 'tuteur')));
			$menu['Emplois du temps']->addChild('Frequences',
				array(
					'route' => 'frequence_list'
				)
			);

		$menu->addChild('Emplois du temps', array('labelAttributes' => array('className' => 'agenda')));
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

	public function generateEleveMenu($menu)
	{
		$menu->addChild('Fil d\'Ariane', array(
			'labelAttributes' => array(
				'className' => 'ariane',  
			),
			'route' => 'ariane_homepage'
		));   
		$menu->addChild('Mon emploi du temps', array(
			'labelAttributes' => array(
				'className' => 'edt',  
			),
			'route' => 'edt_homepage'
		)); 
		$menu->addChild('1984', array(
			'labelAttributes' => array(
				'className' => 'bigbro',  
			)
		));  
		$menu['1984']->addChild('Mes notes', 
			array(
				'route' => 'kub_notes_eleve_homepage',
			)
		);
	}

	public function generateProfesseurMenu($menu)
	{
		$menu->addChild('Mes groupes', array('labelAttributes' => array('className' => 'groupes')));
				
			$groupes = $this->em->getRepository('KubClasseBundle:Groupe')->getGroupesOfProfesseur( $this->security->getToken()->getUser() );

			foreach ($groupes as $key => $groupe) {

				$menu['Mes groupes']->addChild($groupe, 
					array(
						'route' => 'groupe_show',
						'routeParameters' => array('id' => $groupe->getId())
					)
				);
			}
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