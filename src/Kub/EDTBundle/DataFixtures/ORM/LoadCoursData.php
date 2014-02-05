<?php

namespace Kub\EDTBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Kub\EDTBundle\Entity\Cours;
use Kub\EDTBundle\Entity\Horaire;


class LoadCoursData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
		$coursAnglaisSI2 = new Cours;

			$coursAnglaisSI2->setProfesseur( $this->getReference('terrypratchett') );
			$coursAnglaisSI2->addGroupe( $this->getReference('SI2') );
			$coursAnglaisSI2->setMatiere( $this->getReference('Anglais') );

			$horaire1 = new Horaire;
			$horaire1->setDebut( new \Datetime('13:30') );
			$horaire1->setFin( new \Datetime('14:30') );
			$horaire1->setJour( $this->getReference('jeudi') );
			$horaire1->addSemaine( $this->getReference('semaine1-2014') );

			$horaire2 = new Horaire;
			$horaire2->setDebut( new \Datetime('08:00') );
			$horaire2->setFin( new \Datetime('09:00') );
			$horaire2->setJour( $this->getReference('mardi') );
			$horaire2->addSemaine( $this->getReference('semaine1-2014') );

			$horaire3 = new Horaire;
			$horaire3->setDebut( new \Datetime('14:30') );
			$horaire3->setFin( new \Datetime('15:30') );
			$horaire3->setJour( $this->getReference('mardi') );
			$horaire3->addSemaine( $this->getReference('semaine1-2014') );

			$coursAnglaisSI2->addHoraire($horaire1);
			$coursAnglaisSI2->addHoraire($horaire2);
			$coursAnglaisSI2->addHoraire($horaire3);
			$this->addReference('coursAnglaisSI2', $coursAnglaisSI2);

		$manager->persist($coursAnglaisSI2);
		$manager->flush();

		$coursSI1SI2 = new Cours;

			$coursSI1SI2->setProfesseur( $this->getReference('stevejobs') );
			$coursSI1SI2->addGroupe( $this->getReference('SI2') );
			$coursSI1SI2->setMatiere( $this->getReference('SI') );

			$horaire1 = new Horaire;
			$horaire1->setDebut( new \Datetime('08:00') );
			$horaire1->setFin( new \Datetime('10:00') );
			$horaire1->setJour( $this->getReference('lundi') );
			$horaire1->addSemaine( $this->getReference('semaine1-2014') );

			$horaire2 = new Horaire;
			$horaire2->setDebut( new \Datetime('11:00') );
			$horaire2->setFin( new \Datetime('12:00') );
			$horaire2->setJour( $this->getReference('jeudi') );
			$horaire2->addSemaine( $this->getReference('semaine1-2014') );

			$coursSI1SI2->addHoraire($horaire1);
			$coursSI1SI2->addHoraire($horaire2);
			$this->addReference('coursSI1SI2', $coursSI1SI2);

		$manager->persist($coursSI1SI2);
		$manager->flush();

		$coursSI2SI2 = new Cours;

			$coursSI2SI2->setProfesseur( $this->getReference('billgates') );
			$coursSI2SI2->addGroupe( $this->getReference('SI2') );
			$coursSI2SI2->setMatiere( $this->getReference('SI') );

			$horaire1 = new Horaire;
			$horaire1->setDebut( new \Datetime('10:00') );
			$horaire1->setFin( new \Datetime('12:00') );
			$horaire1->setJour( $this->getReference('lundi') );
			$horaire1->addSemaine( $this->getReference('semaine1-2014') );

			$horaire2 = new Horaire;
			$horaire2->setDebut( new \Datetime('10:00') );
			$horaire2->setFin( new \Datetime('11:00') );
			$horaire2->setJour( $this->getReference('jeudi') );
			$horaire2->addSemaine( $this->getReference('semaine1-2014') );

			$coursSI2SI2->addHoraire($horaire1);
			$coursSI2SI2->addHoraire($horaire2);
			$this->addReference('coursSI2SI2', $coursSI2SI2);

		$manager->persist($coursSI2SI2);
		$manager->flush();

		$coursPhysiqueSI2 = new Cours;

			$coursPhysiqueSI2->setProfesseur( $this->getReference('mariecury') );
			$coursPhysiqueSI2->addGroupe( $this->getReference('SI2') );
			$coursPhysiqueSI2->setMatiere( $this->getReference('Physique') );

			$horaire1 = new Horaire;
			$horaire1->setDebut( new \Datetime('11:00') );
			$horaire1->setFin( new \Datetime('12:30') );
			$horaire1->setJour( $this->getReference('mardi') );
			$horaire1->addSemaine( $this->getReference('semaine1-2014') );

			$horaire2 = new Horaire;
			$horaire2->setDebut( new \Datetime('14:30') );
			$horaire2->setFin( new \Datetime('16:00') );
			$horaire2->setJour( $this->getReference('jeudi') );
			$horaire2->addSemaine( $this->getReference('semaine1-2014') );

			$coursPhysiqueSI2->addHoraire($horaire1);
			$coursPhysiqueSI2->addHoraire($horaire2);
			$this->addReference('coursPhysiqueSI2', $coursPhysiqueSI2);

		$manager->persist($coursPhysiqueSI2);
		$manager->flush();

		$coursMathsSI2 = new Cours;

			$coursMathsSI2->setProfesseur( $this->getReference('rogerpythagore') );
			$coursMathsSI2->addGroupe( $this->getReference('SI2') );
			$coursMathsSI2->setMatiere( $this->getReference('Mathématiques') );

			$horaire1 = new Horaire;
			$horaire1->setDebut( new \Datetime('09:00') );
			$horaire1->setFin( new \Datetime('10:00') );
			$horaire1->setJour( $this->getReference('mardi') );
			$horaire1->addSemaine( $this->getReference('semaine1-2014') );

			$horaire2 = new Horaire;
			$horaire2->setDebut( new \Datetime('16:00') );
			$horaire2->setFin( new \Datetime('17:00') );
			$horaire2->setJour( $this->getReference('jeudi') );
			$horaire2->addSemaine( $this->getReference('semaine1-2014') );

			$horaire2 = new Horaire;
			$horaire2->setDebut( new \Datetime('10:00') );
			$horaire2->setFin( new \Datetime('12:00') );
			$horaire2->setJour( $this->getReference('vendredi') );
			$horaire2->addSemaine( $this->getReference('semaine1-2014') );

			$coursMathsSI2->addHoraire($horaire1);
			$coursMathsSI2->addHoraire($horaire2);
			$coursMathsSI2->addHoraire($horaire3);
			$this->addReference('coursMathsSI2', $coursMathsSI2);

		$manager->persist($coursMathsSI2);
		$manager->flush();

		$coursEspagnolSI2 = new Cours;

			$coursEspagnolSI2->setProfesseur( $this->getReference('penelopecruz') );
			$coursEspagnolSI2->addGroupe( $this->getReference('SI2') );
			$coursEspagnolSI2->setMatiere( $this->getReference('Espagnol') );

			$horaire1 = new Horaire;
			$horaire1->setDebut( new \Datetime('10:00') );
			$horaire1->setFin( new \Datetime('11:00') );
			$horaire1->setJour( $this->getReference('mardi') );
			$horaire1->addSemaine( $this->getReference('semaine1-2014') );

			$horaire2 = new Horaire;
			$horaire2->setDebut( new \Datetime('08:00') );
			$horaire2->setFin( new \Datetime('09:00') );
			$horaire2->setJour( $this->getReference('mercredi') );
			$horaire2->addSemaine( $this->getReference('semaine1-2014') );

			$coursEspagnolSI2->addHoraire($horaire1);
			$coursEspagnolSI2->addHoraire($horaire2);
			$this->addReference('coursEspagnolSI2', $coursEspagnolSI2);

		$manager->persist($coursEspagnolSI2);
		$manager->flush();

		$coursTPESI2 = new Cours;

			$coursTPESI2->setProfesseur( $this->getReference('stevesjobs') );
			$coursTPESI2->addGroupe( $this->getReference('SI2') );
			$coursTPESI2->setMatiere( $this->getReference('TPE') );

			$horaire1 = new Horaire;
			$horaire1->setDebut( new \Datetime('15:30') );
			$horaire1->setFin( new \Datetime('17:30') );
			$horaire1->setJour( $this->getReference('mardi') );
			$horaire1->addSemaine( $this->getReference('semaine1-2014') );

			$coursTPESI2->addHoraire($horaire1);
			$this->addReference('coursTPESI2', $coursTPESI2);

		$manager->persist($coursTPESI2);
		$manager->flush();
	}

	public function getOrder()
	{
		return 5; // l'ordre dans lequel les fichiers sont chargés
	}
}