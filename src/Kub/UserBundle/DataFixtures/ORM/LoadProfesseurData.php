<?php

namespace Kub\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;


use Kub\UserBundle\Entity\Professeur;


class LoadProfesseurData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
	/**
	 * @var ContainerInterface
	 */
	private $container;

	/**
	 * {@inheritDoc}
	 */
	public function setContainer(ContainerInterface $container = null)
	{
		$this->container = $container;
	}

	/**
	 * {@inheritDoc}
	 */
	public function load(ObjectManager $manager)
	{
		$discriminator = $this->container->get('pugx_user.manager.user_discriminator');
		$discriminator->setClass('Kub\UserBundle\Entity\Professeur');

		$userManager = $this->container->get('pugx_user_manager');
		$professeur = $userManager->createUser();

		$professeur->setNom('Bach');
		$professeur->setPrenom('Jean-Sebastien');

		$professeur->setEmail('admina@mail.com');
		$professeur->setPlainPassword('123456');
		$professeur->setEnabled(true);

		$this->addReference('professeur', $professeur);

		$userManager->updateUser($professeur, true);

		$professeur = $userManager->createUser();

		$professeur->setNom('Pagnol');
		$professeur->setPrenom('Marcel');

		$professeur->setEmail('mpagnol@mail.com');
		$professeur->setPlainPassword('123456');
		$professeur->setEnabled(true);

		$userManager->updateUser($professeur, true);

		$professeurs = array(
			
			"Steve" => "Jobs",
			"Bill" => "Gates",

			"Karl" => "Marx",
			"Nikolaï" => "Kondratiev",

			"Albert" => "Camus",

			"Marie" => "Cury",
			"Albert" => "Einstein",

			"Usain" => "Bolt",
			"Laure" => "Manaudou",

			"William" => "Shakespeare",
			"Terry" => "Pratchett",

			"Matthieu" => "Rajohnson",
			"Christophe" => "Colomb",

			"Isaac" => "Newton",
			"Roger" => "Pythagore",

			"Guillermo" => "Del Toro",
			"Penelope" => "Cruz"
		);

		foreach($professeurs as $nom => $prenom)
		{
			$professeur = $userManager->createUser();
			$pseudo = strToLower($nom . $prenom) ;

			$professeur->setNom($nom);
			$professeur->setPrenom($prenom);

			$professeur->setEmail($pseudo . '@mail.com');
			$professeur->setPlainPassword(substr(hash('sha512', uniqid()), 0, 20));
			$professeur->setEnabled(true);

			$this->addReference($pseudo, $professeur);
			$userManager->updateUser($professeur, true);	
		}
	}

	public function getOrder()
	{
		return 2; // l'ordre dans lequel les fichiers sont chargés
	}
}