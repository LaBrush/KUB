<?php

namespace Kub\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;


use Kub\UserBundle\Entity\Eleve;


class LoadEleveData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
		$discriminator->setClass('Kub\UserBundle\Entity\Eleve');

		$userManager = $this->container->get('pugx_user_manager');

		/*------------------------------------*/
		$johnsnow = $userManager->createUser();

		$johnsnow->setNom('Snow');
		$johnsnow->setPrenom('John');
		$johnsnow->setAnniversaire(new \Datetime());
		$johnsnow->setNiveau($this->getReference('premiere'));

		$johnsnow->setEmail('admin@mail.com');
		$johnsnow->setPlainPassword('123456');
		$johnsnow->setEnabled(true);
		$this->getReference("si3")->addEleve($johnsnow);

		$this->addReference('johnsnow', $johnsnow);
		$userManager->updateUser($johnsnow, true);

		/*------------------------------------*/
		$deneris = $userManager->createUser();

		$deneris->setNom('Thargarien');
		$deneris->setPrenom('Deneris');
		$deneris->setAnniversaire(new \Datetime());
		$deneris->setNiveau($this->getReference('premiere'));
		$this->getReference("si3")->addEleve($deneris);

		$deneris->setEmail('adfdmin@mail.com');
		$deneris->setPlainPassword('123456');
		$deneris->setEnabled(true);

		$this->addReference('deneristhargarien', $deneris);
		$userManager->updateUser($deneris, true);

		$eleves = array(
			"John" => "Thargarien",
			"Franck" => "Déodat",
			"Dortha" => "Deveau",
			"Linette" => "Lindsay",
			"Abram" => "Albury",
			"Earl" => "Elkins",
			"Carola" => "Cookingham",
			"Valorie" => "Vazques",
			"Eula" => "Ericson",
			"Bethany" => "Belanger",
			"Charlette" => "Canipe",
			"Giovanni" => "Grenz",
			"Muriel" => "Mater",
			"Felix" => "Forte",
			"Sheridan" => "Stannard",
			"Kenyatta" => "Klar",
			"Maril" => "Muoshier",
			"Mika" => "Marcus",
			"Ione" => "Icenhour",
			"Virgie" => "Vannote",
			"Sondra" => "Schlenker",
			"Dionna" => "Diehm",
			"Evelia" => "Eidson",
			"Bradly" => "Burpo",
			"Krishna" => "Kron",
			"Cecile" => "Claycomb",
			"Keisha" => "Karls",
			"Luigi" => "Loveall",
			"Classie" => "Castruita",
			"Dessie" => "Dunne",
			"Randal" => "Roses",
			"Blair" => "Breunig",
			"Cristine" => "Como",
			"Kareem" => "Keegan",
			"Jordon" => "Jordan",
			"Catherina" => "Cephasiedre",
			"Lilla" => "Laurich",
			"Alyson" => "Arnone",
			"Stacie" => "Stickley",
			"Benita" => "Blazek",
			"Nova" => "Nygren",
			"Aliza" => "Ahner",
			"Florida" => "Filippi",
			"Rosario" => "Ratzlaff",
			"Ada" => "Antilla",
			"Fredrick" => "Fischbach",
			"Suzann" => "Sant",
			"Rosa" => "Rauscher",
			"Dani" => "Delucca"
		);

		foreach($eleves as $prenom => $nom)
		{
			$eleve = $userManager->createUser();
			$pseudo = strToLower($nom . $prenom) ;

			$eleve->setNom($nom);
			$eleve->setPrenom($prenom);
			$eleve->setAnniversaire(new \Datetime());
			$eleve->setNiveau($this->getReference('premiere'));

			$eleve->setEmail($pseudo . '@mail.com');
			$eleve->setPlainPassword('123456');
			$eleve->setEnabled(true);

			$this->getReference("si3")->addEleve($eleve);

			$this->addReference($pseudo, $eleve);
			$userManager->updateUser($eleve, true);	
		}
	}

	public function getOrder()
	{
		return 2; // l'ordre dans lequel les fichiers sont chargés
	}
}