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


		/* Nom des eleves par classes */

		$eleves1 = array(
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
			"Luigi" => "Loveall"
		);

		$eleves2 = array(
			"Lisa" => "Rigault",
			"Louna" => "Ballet",
			"Lina" => "Ollier",
			"Louane" => "Auffret",
			"Leane" => "Mignon",
			"Marine" => "Lamy",
			"Clara" => "Legarrec",
			"Emilie" => "Carles",
			"Andrea" => "Henrion",
			"Lilou" => "Giry",
			"Amelie" => "Leclercq",
			"Elise" => "Lemoal",
			"Andrea" => "Chevallier",
			"Lucie" => "Clavel",
			"Margaux" => "Bayard",
			"Clemence" => "Bourdon",
			"Ada" => "Antilla",
			"Fredrick" => "Fischbach",
			"Suzann" => "Sant",
			"Rosa" => "Rauscher",
			"Dani" => "Delucca",
			"Marc" => "Ray",
			"Florian" => "Faucheux",
			"Antoine" => "Delporte",
			"Yves" => "Cuvillier",
			"Jacques" => "Ly",
			"Jean-François" => "Moisan",
			"René" => "Saunier",
			"André" => "Coudray",
			"Frédéric" => "Charlot"
		);

		$eleves3 = array(
			"Louane" => "Cadiou",
			"Eloise" => "Hoarau",
			"Juliette" => "Hartmann",
			"Rose" => "Menard",
			"Emilie" => "Daval",
			"Amandine" => "Doyen",
			"Amelie" => "Chanut",
			"Laurine" => "Bignon",
			"Andrea" => "Brossard",
			"Capucine" => "Morillon",
			"Alexia" => "Maurice",
			"Jade" => "Pinet",
			"Manon" => "Avril",
			"Myriam" => "Pollet",
			"Ambre" => "Boursier",
			"Elsa" => "Cazenave",
			"Jean-Marie" => "Guillaumin",
			"Frédéric" => "Gambier",
			"Thierry" => "Millot",
			"Bruno" => "Bordes",
			"Yannick" => "Bey",
			"Robert" => "Jouve",
			"Stéphane" => "Guth",
			"Emile" => "Bouchard",
			"Georges" => "Bellot",
			"Yves" => "Porte",
			"René" => "Bayart",
			"Jean-Pierre" => "Rollin",
			"Jean-Luc" => "Perrot",
			"Richard" => "Revel"
		);

		$eleves4 = array(
			"Alexia" => "Kuhn",
			"Lina" => "Vergne",
			"Pauline" => "Peyre",
			"Elena" => "Lo",
			"Louna" => "Thiery",
			"Salome" => "Bobo",
			"Coline" => "Herault",
			"Lena" => "Barbe",
			"Coline" => "Faye",
			"Mathilde" => "Grimaldi",
			"Meline" => "Brisset",
			"Yasmine" => "Bouche",
			"Charlotte" => "Delrue",
			"Fanny" => "Pierret",
			"Eloise" => "Negre",
			"Maelle" => "Marquet",
			"Frédéric" => "Girault",
			"Jacques" => "Desjardins",
			"Jean-Claude" => "Messager",
			"Alain" => "Guillaume",
			"Serge" => "Lafargue",
			"Franck" => "Audouin",
			"Stéphane" => "Lecomte",
			"Jean-Marc" => "Pernot",
			"Fabrice" => "Daniel",
			"Kevin" => "Sabatier",
			"Bruno" => "Cordonnier",
			"Vincent" => "Gabriel",
			"Emile" => "Marchand",
			"Patrick" => "Vieira"
		);

		$eleves5 = array(
			"Elise" => "Pion",
			"Gabrielle" => "Renaud",
			"Jade" => "Bazin",
			"Capucine" => "Rouillard",
			"Alexia" => "Leguern",
			"Melina" => "Person",
			"Cloe" => "Dietrich",
			"Maelle" => "Ramos",
			"Gabrielle" => "Bianchi",
			"Amandine" => "Henry",
			"Elisa" => "Ben",
			"Alexia" => "Roy",
			"Elsa" => "Crepin",
			"Mathilde" => "Marquet",
			"Emma" => "Guillet",
			"Solene" => "Boyer",
			"Robert" => "Jouan",
			"Guillaume" => "Henaff",
			"Jean-Marie" => "Thiry",
			"Alexis" => "Simonet",
			"Dominique" => "Leclere",
			"Jean-Claude" => "Moret",
			"Louis" => "Lapeyre",
			"Vincent" => "Gillard",
			"Maxime" => "Dupont",
			"Jean-Michel" => "Floch",
			"Richard" => "Blais",
			"Anthony" => "Hue",
			"Jérémy" => "Bordes",
			"Alain" => "Magnin"
		);

		$eleves6 = array(
			"Morgane" => "Bessiere",
			"Camille" => "Duclos",
			"Yasmine" => "Roth",
			"Leonie" => "Payet",
			"Noemie" => "Bard",
			"Nina" => "Carvalho",
			"Chloe" => "Hue",
			"Zoe" => "Boulanger",
			"Lina" => "Graff",
			"Romane" => "Causse",
			"Lana" => "Meyer",
			"Carla" => "Blin",
			"Capucine" => "Rousselle",
			"Valentine" => "Busson",
			"Oceane" => "Guyon",
			"Alexia" => "Sueur",
			"Philippe" => "Nourry",
			"Richard" => "Baudoin",
			"Romain" => "Pichard",
			"Albert" => "Lariviere",
			"Mickaël" => "Doucet",
			"Stéphane" => "Cortes",
			"Antoine" => "Robert",
			"Alexis" => "Tardieu",
			"Daniel" => "Vandamme",
			"Adrien" => "Guery",
			"Patrick" => "Potel",
			"Jean-Marc" => "Grenet",
			"Thierry" => "Brault",
			"Gilles" => "Guitard"
		);

		$eleves7 = array(
			"Clemence" => "Larite",
			"Ninon" => "Boyer",
			"Elena" => "Combes",
			"Eloise" => "Momo",
			"Victoria" => "Morvan",
			"Luna" => "Luciani",
			"Lise" => "Henriot",
			"Lola" => "Copin",
			"Noemie" => "Sire",
			"Ninon" => "Ziegler",
			"Elise" => "Guesdon",
			"Lilou" => "Plisson",
			"Julia" => "Mendes",
			"Justine" => "Lecointe",
			"Yasmine" => "Lebert",
			"Melissa" => "Ragot",
			"Loïc" => "Tual",
			"Jean" => "Causse",
			"Jean-Pierre" => "Rannou",
			"Philippe" => "Coquet",
			"Laurent" => "Poncelet",
			"Robert" => "Deloffre",
			"David" => "Toutain",
			"Jean-Michel" => "sousa",
			"Denis" => "Metais",
			"Frédéric" => "Segura",
			"Sylvain" => "Bonnard",
			"Nicolas" => "Gutierrez",
			"Olivier" => "Victor",
			"Gérard" => "Heritier"
		);

		$eleves8 = array(
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
			"Marc" => "Rousseau",
			"Joseph" => "Faucon",
			"Richard" => "Anton",
			"Raymond" => "Humbert",
			"Fabrice" => "Neuville",
			"Clément" => "Rigaud",
			"Denis" => "Nowak",
			"Marc" => "Vernet",
			"Franck" => "Huard",
			"Maurice" => "Michelet",
			"Robert" => "Duquenne",
			"Christian" => "Cardoso",
			"Gilbert" => "Foucher",
			"Jean" => "Lagarde"
		);

		$eleves9 = array(
			"Fabien" => "Prieur",
			"Emile" => "Albertini",
			"Emile" => "Robillard",
			"Antoine" => "Piriou",
			"Frédéric" => "Thibaud",
			"Jonathan" => "Bichon",
			"Lionel" => "Escoffier",
			"Pascal" => "Leprince",
			"Albert" => "Boudin",
			"Jean-François" => "Hilaire",
			"Robert" => "Lebert",
			"Anna" => "Beaufils",
			"Celia" => "Roca",
			"Maeva" => "Corbin",
			"Elisa" => "Martinez",
			"Gabrielle" => "Gasnier",
			"Anaelle" => "Monteil",
			"Anna" => "Duran",
			"Salome" => "James",
			"Eva" => "Guillaumin",
			"Lana" => "Lasnier",
			"Marion" => "Bart",
			"Lana" => "Brochard",
			"Alice" => "Picot",
			"Lily" => "Peres",
			"Leane" => "Steinmetz",
			"Camille" => "Paulin",
			"Lana" => "Dang",
			"Nina" => "Raynaud",
			"Elisa" => "Giraud"
		);

		$eleves10 = array(
			"Gérard" => "Bossard",
			"Michel" => "Lalande",
			"Anthony" => "Teyssier",
			"Vincent" => "Lavaud",
			"Serge" => "Seguy",
			"Maxime" => "Grenier",
			"Jacques" => "Loyer",
			"Guy" => "Blouin",
			"Serge" => "Huynh",
			"Gilles" => "Berthier",
			"Jérémy" => "Berthe",
			"Jacques" => "Monnier",
			"Jean-Paul" => "Fradin",
			"Yves" => "Lebrun",
			"Anthony" => "Malet",
			"Mickaël" => "Jerome",
			"Olivia" => "Philippot",
			"Ambre" => "Bergeron",
			"Melissa" => "Jacquot",
			"Capucine" => "Babin",
			"Eloise" => "Heritier",
			"Jeanne" => "Lacaze",
			"Pauline" => "Evain",
			"Maelle" => "Coulon",
			"Anais" => "Lecorre",
			"Chloe" => "Renaudin",
			"Ninon" => "Rannou",
			"Luna" => "Caille",
			"Angelina" => "Duboc",
			"Carla" => "Diaz"
		);

		$eleves11 = array(
			"David" => "Clouet",
			"Guillaume" => "Molina",
			"Patrick" => "Ferrero",
			"Jean-Paul" => "Bourdais",
			"David" => "Ollivier",
			"Xavier" => "Roger",
			"Pascal" => "Picot",
			"Emmanuel" => "Brule",
			"Bruno" => "Hamon",
			"Lucien" => "Talbot",
			"Eric" => "Henaff",
			"Yannick" => "Barbet",
			"François" => "Soares",
			"Jacques" => "Renou",
			"Benjamin" => "Rousselet",
			"Georges" => "Schwartz",
			"Luna" => "Rouge",
			"Maeva" => "Fabre",
			"Anaelle" => "Lafarge",
			"Louane" => "Moreau",
			"Manon" => "Jacob",
			"Elena" => "Lecam",
			"Mathilde" => "Maisonneuve",
			"Olivia" => "Daumas",
			"Clarisse" => "Gonzales",
			"Ambre" => "Loriot",
			"Elise" => "Lecourt",
			"Flavie" => "Crouzet",
			"Nina" => "Bizet",
			"Alice" => "Ledoux"
		);

		$eleves12 = array(
			"Jean" => "Dede",
			"Pierre" => "Marino",
			"Roland" => "Blondeau",
			"Yannick" => "Nicolas",
			"Patrick" => "Bordes",
			"Marc" => "Seite",
			"Florian" => "Perrot",
			"Pierre" => "Colonna",
			"Georges" => "Dubus",
			"Jérémy" => "Derouet",
			"Mickaël" => "Alvarez",
			"Lucien" => "Mary",
			"Julien" => "Ragot",
			"Adrien" => "Pelissier",
			"Marc" => "Constant",
			"Albert" => "Benoit",
			"Sarah" => "Legras",
			"Julie" => "Evrard",
			"Alicia" => "Mattei",
			"Cassandra" => "Moret",
			"Eloise" => "Auclair",
			"Julia" => "Creton",
			"Maelys" => "Lasnier",
			"Anaelle" => "Avril",
			"Claire" => "Serra",
			"Mathilde" => "Rigaud",
			"Lina" => "Joyeux",
			"Elisa" => "Grelier",
			"Laurine" => "Maillard",
			"Alicia" => "Jerome"
		);

		$eleves13 = array(
			"Paul" => "Metivier",
			"Gilbert" => "Henon",
			"Alexis" => "Cornu",
			"Eric" => "Billy",
			"Patrice" => "Carriere",
			"Sylvain" => "Colin",
			"Benjamin" => "Luciani",
			"Lucien" => "Bris",
			"Patrice" => "Chatel",
			"Nicolas" => "Barbe",
			"Vincent" => "Lefrancois",
			"Mickaël" => "Feron",
			"Adrien" => "Renaud",
			"Anthony" => "Moisan",
			"René" => "Demay",
			"Raymond" => "Frere",
			"Elena" => "Blache",
			"Coline" => "Lemercier",
			"Ines" => "Boucard",
			"Lina" => "Jaubert",
			"Melina" => "Duval",
			"Sofia" => "Letellier",
			"Cassandra" => "Bosc",
			"Ambre" => "Michaud",
			"Clarisse" => "Victor",
			"Louane" => "Calvet",
			"Capucine" => "Mille",
			"Laurine" => "Henriot",
			"Manon" => "Lagrange",
			"Manon" => "Duclos"
		);

		$eleves14 = array(
			"Marcel" => "Peyrard",
			"René" => "Ory",
			"Jean-Paul" => "Guillotin",
			"Denis" => "Betton",
			"Serge" => "Bellet",
			"Guillaume" => "Jardin",
			"André" => "Barbier",
			"André" => "Lavigne",
			"Maurice" => "Melin",
			"Yannick" => "Rolland",
			"Mathieu" => "Lemee",
			"Jean-Pierre" => "Diaz",
			"Joseph" => "Baumann",
			"Fabrice" => "Ruiz",
			"Cédric" => "Collomb",
			"Bruno" => "Rabier",
			"Lily" => "Astruc",
			"Meline" => "Raffin",
			"Charlotte" => "Mourier",
			"Margot" => "Jegou",
			"Loane" => "Pinel",
			"Justine" => "Taupin",
			"Chloe" => "Leon",
			"Myriam" => "Pinson",
			"Juliette" => "Nicol",
			"Agathe" => "Savin",
			"Ambre" => "Walter",
			"Clara" => "Charvet",
			"Victoria" => "Grimaud",
			"Oceane" => "Maurel"
		);

		$eleves15 = array(
			"Alexis" => "Bodet",
			"René" => "Maire",
			"Fabien" => "Brousse",
			"Fabrice" => "Dubus",
			"Henri" => "Claude",
			"Gilles" => "Pont",
			"François" => "Bergeron",
			"Louis" => "Bonnot",
			"René" => "Bertaud",
			"Jean-Paul" => "Humbert",
			"André" => "Rouet",
			"Laurent" => "Lecam",
			"Thomas" => "Gloaguen",
			"Benoît" => "Pont",
			"Pierre" => "Tison",
			"Michel" => "Jourdan",
			"Loane" => "Chabanne",
			"Victoria" => "Lapeyre",
			"Clara" => "Leclere",
			"Lana" => "Villain",
			"Coline" => "Champion",
			"Lily" => "Marie",
			"Victoria" => "Negre",
			"Marine" => "Ngo",
			"Yasmine" => "Genty",
			"Andrea" => "Legac",
			"Maelys" => "Colin",
			"Lena" => "Monier",
			"Lea" => "Fontaine",
			"Lena" => "Baptiste"
		);

		/* Generation des classes par liste d'eleve */

		foreach($eleves1 as $prenom => $nom)
		{
			$eleve = $userManager->createUser();
			$pseudo = strToLower($nom . $prenom) ;

			$eleve->setNom($nom);
			$eleve->setPrenom($prenom);
			$eleve->setAnniversaire(new \Datetime());
			$eleve->setNiveau($this->getReference('seconde'));

			$eleve->setEmail($pseudo . '@mail.com');
			$eleve->setPlainPassword(sha512(substr(uniqid(), 0, 20)));
			$eleve->setEnabled(true);

			$this->getReference("1")->addEleve($eleve);

			$this->addReference($pseudo, $eleve);
			$userManager->updateUser($eleve, true);	
		}

		foreach($eleves2 as $prenom => $nom)
		{
			$eleve = $userManager->createUser();
			$pseudo = strToLower($nom . $prenom) ;

			$eleve->setNom($nom);
			$eleve->setPrenom($prenom);
			$eleve->setAnniversaire(new \Datetime());
			$eleve->setNiveau($this->getReference('seconde'));

			$eleve->setEmail($pseudo . '@mail.com');
			$eleve->setPlainPassword(sha512(substr(uniqid(), 0, 20)));
			$eleve->setEnabled(true);

			$this->getReference("2")->addEleve($eleve);

			$this->addReference($pseudo, $eleve);
			$userManager->updateUser($eleve, true);	
		}

		foreach($eleves3 as $prenom => $nom)
		{
			$eleve = $userManager->createUser();
			$pseudo = strToLower($nom . $prenom) ;

			$eleve->setNom($nom);
			$eleve->setPrenom($prenom);
			$eleve->setAnniversaire(new \Datetime());
			$eleve->setNiveau($this->getReference('seconde'));

			$eleve->setEmail($pseudo . '@mail.com');
			$eleve->setPlainPassword(sha512(substr(uniqid(), 0, 20)));
			$eleve->setEnabled(true);

			$this->getReference("3")->addEleve($eleve);

			$this->addReference($pseudo, $eleve);
			$userManager->updateUser($eleve, true);	
		}

		foreach($eleves4 as $prenom => $nom)
		{
			$eleve = $userManager->createUser();
			$pseudo = strToLower($nom . $prenom) ;

			$eleve->setNom($nom);
			$eleve->setPrenom($prenom);
			$eleve->setAnniversaire(new \Datetime());
			$eleve->setNiveau($this->getReference('premiere'));

			$eleve->setEmail($pseudo . '@mail.com');
			$eleve->setPlainPassword(sha512(substr(uniqid(), 0, 20)));
			$eleve->setEnabled(true);

			$this->getReference("SI")->addEleve($eleve);

			$this->addReference($pseudo, $eleve);
			$userManager->updateUser($eleve, true);	
		}

		foreach($eleves5 as $prenom => $nom)
		{
			$eleve = $userManager->createUser();
			$pseudo = strToLower($nom . $prenom) ;

			$eleve->setNom($nom);
			$eleve->setPrenom($prenom);
			$eleve->setAnniversaire(new \Datetime());
			$eleve->setNiveau($this->getReference('premiere'));

			$eleve->setEmail($pseudo . '@mail.com');
			$eleve->setPlainPassword(sha512(substr(uniqid(), 0, 20)));
			$eleve->setEnabled(true);

			$this->getReference("S")->addEleve($eleve);

			$this->addReference($pseudo, $eleve);
			$userManager->updateUser($eleve, true);	
		}

		foreach($eleves6 as $prenom => $nom)
		{
			$eleve = $userManager->createUser();
			$pseudo = strToLower($nom . $prenom) ;

			$eleve->setNom($nom);
			$eleve->setPrenom($prenom);
			$eleve->setAnniversaire(new \Datetime());
			$eleve->setNiveau($this->getReference('premiere'));

			$eleve->setEmail($pseudo . '@mail.com');
			$eleve->setPlainPassword(sha512(substr(uniqid(), 0, 20)));
			$eleve->setEnabled(true);

			$this->getReference("ES")->addEleve($eleve);

			$this->addReference($pseudo, $eleve);
			$userManager->updateUser($eleve, true);	
		}

		foreach($eleves7 as $prenom => $nom)
		{
			$eleve = $userManager->createUser();
			$pseudo = strToLower($nom . $prenom) ;

			$eleve->setNom($nom);
			$eleve->setPrenom($prenom);
			$eleve->setAnniversaire(new \Datetime());
			$eleve->setNiveau($this->getReference('premiere'));

			$eleve->setEmail($pseudo . '@mail.com');
			$eleve->setPlainPassword(sha512(substr(uniqid(), 0, 20)));
			$eleve->setEnabled(true);

			$this->getReference("L")->addEleve($eleve);

			$this->addReference($pseudo, $eleve);
			$userManager->updateUser($eleve, true);	
		}

		foreach($eleves8 as $prenom => $nom)
		{
			$eleve = $userManager->createUser();
			$pseudo = strToLower($nom . $prenom) ;

			$eleve->setNom($nom);
			$eleve->setPrenom($prenom);
			$eleve->setAnniversaire(new \Datetime());
			$eleve->setNiveau($this->getReference('premiere'));

			$eleve->setEmail($pseudo . '@mail.com');
			$eleve->setPlainPassword(sha512(substr(uniqid(), 0, 20)));
			$eleve->setEnabled(true);

			$this->getReference("S")->addEleve($eleve);

			$this->addReference($pseudo, $eleve);
			$userManager->updateUser($eleve, true);	
		}

		foreach($eleves9 as $prenom => $nom)
		{
			$eleve = $userManager->createUser();
			$pseudo = strToLower($nom . $prenom) ;

			$eleve->setNom($nom);
			$eleve->setPrenom($prenom);
			$eleve->setAnniversaire(new \Datetime());
			$eleve->setNiveau($this->getReference('seconde'));

			$eleve->setEmail($pseudo . '@mail.com');
			$eleve->setPlainPassword(sha512(substr(uniqid(), 0, 20)));
			$eleve->setEnabled(true);

			$this->getReference("4")->addEleve($eleve);

			$this->addReference($pseudo, $eleve);
			$userManager->updateUser($eleve, true);	
		}

		foreach($eleves10 as $prenom => $nom)
		{
			$eleve = $userManager->createUser();
			$pseudo = strToLower($nom . $prenom) ;

			$eleve->setNom($nom);
			$eleve->setPrenom($prenom);
			$eleve->setAnniversaire(new \Datetime());
			$eleve->setNiveau($this->getReference('terminale'));

			$eleve->setEmail($pseudo . '@mail.com');
			$eleve->setPlainPassword(sha512(substr(uniqid(), 0, 20)));
			$eleve->setEnabled(true);

			$this->getReference("SI")->addEleve($eleve);

			$this->addReference($pseudo, $eleve);
			$userManager->updateUser($eleve, true);	
		}

		foreach($eleves11 as $prenom => $nom)
		{
			$eleve = $userManager->createUser();
			$pseudo = strToLower($nom . $prenom) ;

			$eleve->setNom($nom);
			$eleve->setPrenom($prenom);
			$eleve->setAnniversaire(new \Datetime());
			$eleve->setNiveau($this->getReference('terminale'));

			$eleve->setEmail($pseudo . '@mail.com');
			$eleve->setPlainPassword(sha512(substr(uniqid(), 0, 20)));
			$eleve->setEnabled(true);

			$this->getReference("S")->addEleve($eleve);

			$this->addReference($pseudo, $eleve);
			$userManager->updateUser($eleve, true);	
		}

		foreach($eleves12 as $prenom => $nom)
		{
			$eleve = $userManager->createUser();
			$pseudo = strToLower($nom . $prenom) ;

			$eleve->setNom($nom);
			$eleve->setPrenom($prenom);
			$eleve->setAnniversaire(new \Datetime());
			$eleve->setNiveau($this->getReference('terminale'));

			$eleve->setEmail($pseudo . '@mail.com');
			$eleve->setPlainPassword(sha512(substr(uniqid(), 0, 20)));
			$eleve->setEnabled(true);

			$this->getReference("S")->addEleve($eleve);

			$this->addReference($pseudo, $eleve);
			$userManager->updateUser($eleve, true);	
		}

		foreach($eleves13 as $prenom => $nom)
		{
			$eleve = $userManager->createUser();
			$pseudo = strToLower($nom . $prenom) ;

			$eleve->setNom($nom);
			$eleve->setPrenom($prenom);
			$eleve->setAnniversaire(new \Datetime());
			$eleve->setNiveau($this->getReference('terminale'));

			$eleve->setEmail($pseudo . '@mail.com');
			$eleve->setPlainPassword(sha512(substr(uniqid(), 0, 20)));
			$eleve->setEnabled(true);

			$this->getReference("ES")->addEleve($eleve);

			$this->addReference($pseudo, $eleve);
			$userManager->updateUser($eleve, true);	
		}

		foreach($eleves14 as $prenom => $nom)
		{
			$eleve = $userManager->createUser();
			$pseudo = strToLower($nom . $prenom) ;

			$eleve->setNom($nom);
			$eleve->setPrenom($prenom);
			$eleve->setAnniversaire(new \Datetime());
			$eleve->setNiveau($this->getReference('terminale'));

			$eleve->setEmail($pseudo . '@mail.com');
			$eleve->setPlainPassword(sha512(substr(uniqid(), 0, 20)));
			$eleve->setEnabled(true);

			$this->getReference("L")->addEleve($eleve);

			$this->addReference($pseudo, $eleve);
			$userManager->updateUser($eleve, true);	
		}

		foreach($eleves15 as $prenom => $nom)
		{
			$eleve = $userManager->createUser();
			$pseudo = strToLower($nom . $prenom) ;

			$eleve->setNom($nom);
			$eleve->setPrenom($prenom);
			$eleve->setAnniversaire(new \Datetime());
			$eleve->setNiveau($this->getReference('seconde'));

			$eleve->setEmail($pseudo . '@mail.com');
			$eleve->setPlainPassword(sha512(substr(uniqid(), 0, 20)));
			$eleve->setEnabled(true);

			$this->getReference("5")->addEleve($eleve);

			$this->addReference($pseudo, $eleve);
			$userManager->updateUser($eleve, true);	
		}
	}

	public function getOrder()
	{
		return 2; // l'ordre dans lequel les fichiers sont chargés
	}
}