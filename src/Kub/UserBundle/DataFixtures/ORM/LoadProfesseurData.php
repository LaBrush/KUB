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
			"Casey" => "Goodwin",
			"Lucas" => "Wade",
			"Kristi" => "Roberts",
			"Lamar" => "Ramirez",
			"Pearl" => "Tucker",
			"Stacey" => "Greer",
			"Annette" => "Peterson",
			"Yvette" => "Perez",
			"Jody" => "Morales",
			"Alicia" => "Lyons",
			"Curtis" => "Collier",
			"Tracy" => "Daniel",
			"Gayle" => "Cummings",
			"Manuel" => "Gomez",
			"Pat" => "King",
			"Dean" => "Howard",
			"Dewey" => "Mcdonald",
			"Allen" => "Moody",
			"Rachel" => "Sandoval",
			"Lynn" => "Hubbard",
			"Gretchee" => "Mcgee",
			"Ruby" => "Mitchell",
			"Megan" => "Neal",
			"Jeffery" => "Evans",
			"Ann" => "Adams",
			"Lela" => "Davidson",
			"Dominice" => "Tate",
			"Glenda" => "Rice",
			"Melody" => "Floyd",
			"Ramiro" => "Daniels",
			"June" => "Guerrero",
			"Pete" => "Stevens",
			"Juan" => "Morton",
			"Ramon" => "Palmer",
			"Rudolph" => "Brock",
			"Tara" => "Parker",
			"Faith" => "Fox",
			"Bernice" => "Drake",
			"Vicky" => "Watson",
			"Amy" => "Stevenson",
			"Tommie" => "Wood",
			"Dustin" => "Carter",
			"Bennie" => "White",
			"Dianne" => "Love",
			"Jordan" => "Edwards",
			"Michelle" => "Bates",
			"Andre" => "Vaughn",
			"Marta" => "Perkins",
			"Tom" => "Black",
			"Trevor" => "Patton",
			"Samuel" => "Coleman",
			"Arlene" => "Brooks",
			"Delbert" => "Campbell",
			"Tomas" => "Warner",
			"Marie" => "Wilkins",
			"Kent" => "Burgess",
			"Juanita" => "Brewer",
			"Muriel" => "Copeland",
			"Zachary" => "Taylor",
			"Woodrow" => "Thompson",
			"Bertha" => "Rhodes",
			"Jennifer" => "Osborne",
			"Alma" => "Olson",
			"Theodore" => "Powell",
			"Becky" => "Benson",
			"Norma" => "Glover",
			"Lucia" => "Valdez",
			"Paulette" => "Diaz",
			"Priscilla" => "Potter",
			"Geoffrey" => "Reeves",
			"Alfredo" => "Flores",
			"Charlotte" => "Knight",
			"Sherman" => "Grant",
			"Beth" => "Flowers",
			"Bob" => "Zimmerman",
			"Emilio" => "Long",
			"Luz" => "Douglas",
			"Bonnie" => "Mills",
			"Laura" => "Richards",
			"Sidney" => "Munoz",
			"Bruce" => "Silva",
			"Roman" => "Doyle",
			"Heather" => "Griffin",
			"Lisa" => "Webster",
			"Roberta" => "Perry",
			"Essie" => "Cohen",
			"Mona" => "Conner",
			"Ora" => "Jennings",
			"Dominic" => "Nash",
			"Shaun" => "Vasquez",
			"Steven" => "Hayes",
			"Joel" => "Abbott",
			"Jessica" => "Wells",
			"Jenny" => "Lane",
			"Aaron" => "Caldwell",
			"Amandine" => "Rowe",
			"Leticia" => "Summers",
			"Marie" => "Alvarado",
			"Dolores" => "Swanson",
			"Misty" => "Huff"
		);

		foreach($professeurs as $nom => $prenom)
		{
			$professeur = $userManager->createUser();
			$pseudo = strToLower($nom . $prenom) ;

			$professeur->setNom($nom);
			$professeur->setPrenom($prenom);

			$professeur->setEmail($pseudo . '@mail.com');
			$professeur->setPlainPassword('123456');
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