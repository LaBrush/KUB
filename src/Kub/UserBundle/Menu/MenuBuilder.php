<?php
// src/Acme/MainBundle/Menu/MenuBuilder.php

namespace Kub\UserBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext ;
use Doctrine\ORM\EntityManager ;

class MenuBuilder
{
	private $factory;
	private $security;
	private $em; 
	private $messages;

	public function __construct(FactoryInterface $factory, SecurityContext $security, EntityManager $em, $messages)
	{
		$this->factory = $factory;
		$this->security = $security ;
		$this->em = $em ;
		$this->messages = $messages ;
	}

	public function createMainMenu(Request $request)
	{
		$menu = $this->factory->createItem('root');

		$menu->addChild('Accueil', array(
			'labelAttributes' => array('className' => 'accueil'),
			'route' => 'home_homepage'
		));
			$menu["Accueil"]->addChild('Notifications', array('route' => 'kub_notification_show'));
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

	private function generateMessagesMenu($menu)
	{
		$text = 'Mes messages'; $nb_unread = $this->messages->getNbUnreadMessages();

		if($nb_unread){
			$text .= '<span class="notifications">' . $nb_unread . '</span>';
		}

		$menu["Accueil"]->addChild($text, array('route' => 'kub_messagerie_inbox', 'labelAttributes' => array('className' => 'messagerie')));
	}

	private function generateGroupesMenu($menu)
	{
		$menu->addChild('Mes groupes', array(
			'labelAttributes' => array('className' => 'groupes'),
			'route' => 'groupe_list_for_user'
		));
				
		$groupes = $this->em->getRepository('KubClasseBundle:Groupe')->findByUser( $this->security->getToken()->getUser() );

		$limit = 4 ;
		$limit = $limit < count($groupes) ? $limit : count($groupes) ;

		for($i = 0 ; $i < $limit ; $i++) {

			$menu['Mes groupes']->addChild($groupes[$i], 
				array(
					'route' => 'groupe_show',
					'routeParameters' => array('id' => $groupes[$i]->getId())
				)
			);
		}

		if(count($groupes) > $limit)
		{
			$menu['Mes groupes']->addChild("Autres groupes", 
				array(
					'route' => 'groupe_list_for_user'
				)
			);
		}
	}

	private function generateProjetsMenu($menu)
	{
		$menu->addChild('Mes projets', array(
			'labelAttributes' => array('className' => 'projets'),
			'route' => 'kub_collaboration_homepage'
		));

		$projets = $this->em->getRepository('KubCollaborationBundle:Projet')->findByUser( $this->security->getToken()->getUser() );
		$nb_projets = count($projets);

		$limit = 4 ;
		$limit = $limit < $nb_projets ? $limit : $nb_projets ;

		for($i = 0 ; $i < $limit ; $i++) {

			$menu['Mes projets']->addChild($projets[$i]->getName(), 
				array(
					'route' => 'kub_collaboration_projet_show',
					'routeParameters' => array('slug' => $projets[$i]->getSlug())
				)
			);
		}

		if($nb_projets > $limit)
		{
			$menu['Mes projets']->addChild("Autres projets", 
				array(
					'route' => 'kub_collaboration_homepage'
				)
			);
		} elseif($nb_projets == 0) {
			$menu['Mes projets']->addChild("Créer un projet", 
				array(
					'route' => 'kub_collaboration_projet_create'
				)
			);
		}
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
			$menu['Emplois du temps']->addChild('Cours',
				array(
					'route' => 'cours_list'
				)
			);
			$menu['Emplois du temps']->addChild('Fréquences',
				array(
					'route' => 'frequence_list'
				)
			);
	}

	public function generateEleveMenu($menu)
	{
		$this->generateProjetsMenu($menu);
		$menu->addChild('Espace collaboratif', array('labelAttributes' => array('className' => 'espace-collaboratif')));
			$menu['Espace collaboratif']->addChild('Fil d\'Ariane', array(
				'route' => 'ariane_homepage'
			));   
			$menu['Espace collaboratif']->addChild("Ressources en ligne", array(
				'route' => 'kub_ressource_homepage', 
			));
		$menu->addChild('Ma semaine', array(
			'labelAttributes' => array(
				'className' => 'agenda',  
			),
			'route' => 'edt_homepage'
		)); 
			$menu['Ma semaine']->addChild("Emplois du temps", array(
				'route' => 'edt_homepage', 
			));

		$this->generateGroupesMenu($menu);

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
		$this->generateProjetsMenu($menu);
		$this->generateGroupesMenu($menu);

		$menu->addChild("Ressources en ligne", array(
			'labelAttributes' => array(
				'className' => 'ressources'
			)
		));

		$menu["Ressources en ligne"]->addChild("Consulter", array(
			'route' => 'kub_ressource_homepage', 
		));

		$menu["Ressources en ligne"]->addChild("Ajouter", array(
			'route' => 'kub_ressource_add', 
		));

		$menu["Ressources en ligne"]->addChild("Valider", array(
			'route' => 'kub_ressource_validation_list', 
		));

		$menu->addChild('Ma semaine', array(
			'labelAttributes' => array(
				'className' => 'agenda',  
			),
			'route' => 'edt_homepage'
		)); 
			$menu['Ma semaine']->addChild("Emplois du temps", array(
				'route' => 'edt_homepage', 
			));

		$menu->addChild('1984', array('labelAttributes' => array('className' => 'bigbro')));

		$menu['1984']->addChild('Noter', array(
			'route' => 'kub_notes_professeur_homepage'
		));

		$menu['1984']->addChild('Appel', array(
			'route' => 'kub_absence_professeur_appel'
		));

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