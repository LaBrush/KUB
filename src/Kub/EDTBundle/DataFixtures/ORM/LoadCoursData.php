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
			$horaire1->setDebut( new \Datetime('13:25') );
			$horaire1->setFin( new \Datetime('14:25') );
			$horaire1->setJour( $this->getReference('jeudi') );
			$horaire1->addSemaine( $this->getReference('semaine1-14') );

			$horaire2 = new Horaire;
			$horaire2->setDebut( new \Datetime('08:00') );
			$horaire2->setFin( new \Datetime('09:00') );
			$horaire2->setJour( $this->getReference('vendredi') );
			$horaire2->addSemaine( $this->getReference('semaine1-14') );

			$horaire3 = new Horaire;
			$horaire3->setDebut( new \Datetime('14:25') );
			$horaire3->setFin( new \Datetime('15:20') );
			$horaire3->setJour( $this->getReference('vendredi') );
			$horaire3->addSemaine( $this->getReference('semaine1-14') );

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
			$horaire1->addSemaine( $this->getReference('semaine1-14') );

			$horaire2 = new Horaire;
			$horaire2->setDebut( new \Datetime('11:00') );
			$horaire2->setFin( new \Datetime('12:00') );
			$horaire2->setJour( $this->getReference('jeudi') );
			$horaire2->addSemaine( $this->getReference('semaine1-14') );

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
			$horaire1->addSemaine( $this->getReference('semaine1-14') );

			$horaire2 = new Horaire;
			$horaire2->setDebut( new \Datetime('10:00') );
			$horaire2->setFin( new \Datetime('11:00') );
			$horaire2->setJour( $this->getReference('jeudi') );
			$horaire2->addSemaine( $this->getReference('semaine1-14') );

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
			$horaire1->setFin( new \Datetime('12:25') );
			$horaire1->setJour( $this->getReference('mardi') );
			$horaire1->addSemaine( $this->getReference('semaine1-14') );

			$horaire2 = new Horaire;
			$horaire2->setDebut( new \Datetime('14:25') );
			$horaire2->setFin( new \Datetime('16:00') );
			$horaire2->setJour( $this->getReference('jeudi') );
			$horaire2->addSemaine( $this->getReference('semaine1-14') );

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
			$horaire1->addSemaine( $this->getReference('semaine1-14') );

			$horaire2 = new Horaire;
			$horaire2->setDebut( new \Datetime('16:00') );
			$horaire2->setFin( new \Datetime('17:00') );
			$horaire2->setJour( $this->getReference('jeudi') );
			$horaire2->addSemaine( $this->getReference('semaine1-14') );

			$horaire3 = new Horaire;
			$horaire3->setDebut( new \Datetime('10:00') );
			$horaire3->setFin( new \Datetime('12:00') );
			$horaire3->setJour( $this->getReference('vendredi') );
			$horaire3->addSemaine( $this->getReference('semaine1-14') );

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
			$horaire1->addSemaine( $this->getReference('semaine1-14') );

			$horaire2 = new Horaire;
			$horaire2->setDebut( new \Datetime('08:00') );
			$horaire2->setFin( new \Datetime('09:00') );
			$horaire2->setJour( $this->getReference('mercredi') );
			$horaire2->addSemaine( $this->getReference('semaine1-14') );

			$horaire3 = new Horaire;
			$horaire3->setDebut( new \Datetime('13:25') );
			$horaire3->setFin( new \Datetime('14:25') );
			$horaire3->setJour( $this->getReference('mardi') );
			$horaire3->addSemaine( $this->getReference('semaine1-14') );

			$coursEspagnolSI2->addHoraire($horaire1);
			$coursEspagnolSI2->addHoraire($horaire2);
			$coursEspagnolSI2->addHoraire($horaire3);
			$this->addReference('coursEspagnolSI2', $coursEspagnolSI2);

		$manager->persist($coursEspagnolSI2);
		$manager->flush();

		$coursTPESI2 = new Cours;

			$coursTPESI2->setProfesseur( $this->getReference('stevejobs') );
			$coursTPESI2->addGroupe( $this->getReference('SI2') );
			$coursTPESI2->setMatiere( $this->getReference('TPE') );

			$horaire1 = new Horaire;
			$horaire1->setDebut( new \Datetime('15:20') );
			$horaire1->setFin( new \Datetime('17:20') );
			$horaire1->setJour( $this->getReference('mardi') );
			$horaire1->addSemaine( $this->getReference('semaine1-14') );

			$coursTPESI2->addHoraire($horaire1);
			$this->addReference('coursTPESI2', $coursTPESI2);

		$manager->persist($coursTPESI2);
		$manager->flush();

		$coursSportSI2 = new Cours;

			$coursSportSI2->setProfesseur( $this->getReference('usainbolt') );
			$coursSportSI2->addGroupe( $this->getReference('SI2') );
			$coursSportSI2->setMatiere( $this->getReference('Sport') );

			$horaire1 = new Horaire;
			$horaire1->setDebut( new \Datetime('08:00') );
			$horaire1->setFin( new \Datetime('10:00') );
			$horaire1->setJour( $this->getReference('jeudi') );
			$horaire1->addSemaine( $this->getReference('semaine1-14') );

			$coursSportSI2->addHoraire($horaire1);
			$this->addReference('coursSportSI2', $coursSportSI2);

		$manager->persist($coursSportSI2);
		$manager->flush();

		$coursHistoireGeoSI2 = new Cours;

			$coursHistoireGeoSI2->setProfesseur( $this->getReference('christophecolomb') );
			$coursHistoireGeoSI2->addGroupe( $this->getReference('SI2') );
			$coursHistoireGeoSI2->setMatiere( $this->getReference('Histoire-Géographie') );

			$horaire1 = new Horaire;
			$horaire1->setDebut( new \Datetime('13:25') );
			$horaire1->setFin( new \Datetime('14:25') );
			$horaire1->setJour( $this->getReference('lundi') );
			$horaire1->addSemaine( $this->getReference('semaine1-14') );

			$horaire2 = new Horaire;
			$horaire2->setDebut( new \Datetime('10:00') );
			$horaire2->setFin( new \Datetime('12:00') );
			$horaire2->setJour( $this->getReference('mercredi') );
			$horaire2->addSemaine( $this->getReference('semaine1-14') );

			$coursHistoireGeoSI2->addHoraire($horaire1);
			$coursHistoireGeoSI2->addHoraire($horaire2);
			$this->addReference('coursHistoireGeoSI2', $coursHistoireGeoSI2);

		$manager->persist($coursHistoireGeoSI2);
		$manager->flush();

		$coursFrancaisSI2 = new Cours;

			$coursFrancaisSI2->setProfesseur( $this->getReference('marcelpagnol') );
			$coursFrancaisSI2->addGroupe( $this->getReference('SI2') );
			$coursFrancaisSI2->setMatiere( $this->getReference('Français') );

			$horaire1 = new Horaire;
			$horaire1->setDebut( new \Datetime('15:20') );
			$horaire1->setFin( new \Datetime('17:20') );
			$horaire1->setJour( $this->getReference('lundi') );
			$horaire1->addSemaine( $this->getReference('semaine1-14') );

			$horaire2 = new Horaire;
			$horaire2->setDebut( new \Datetime('09:00') );
			$horaire2->setFin( new \Datetime('10:00') );
			$horaire2->setJour( $this->getReference('vendredi') );
			$horaire2->addSemaine( $this->getReference('semaine1-14') );

			$coursFrancaisSI2->addHoraire($horaire1);
			$coursFrancaisSI2->addHoraire($horaire2);
			$this->addReference('coursFrancaisSI2', $coursFrancaisSI2);

		$manager->persist($coursFrancaisSI2);
		$manager->flush();

		$coursAppel = new Cours;

			$coursAppel->setProfesseur( $this->getReference('thedoctor') );
			$coursAppel->addGroupe( $this->getReference('seconde4') );
			$coursAppel->setMatiere( $this->getReference('TPE') );

			$horaire1 = new Horaire;
			$horaire1->setDebut( new \Datetime('8:00') );
			$horaire1->setFin( new \Datetime('17:20') );
			$horaire1->setJour( $this->getReference('lundi') );
			$horaire1->addSemaine( $this->getReference('semaine1-14') );

			$horaire2 = new Horaire;
			$horaire2->setDebut( new \Datetime('8:00') );
			$horaire2->setFin( new \Datetime('17:20') );
			$horaire2->setJour( $this->getReference('mardi') );
			$horaire2->addSemaine( $this->getReference('semaine1-14') );

			$horaire3 = new Horaire;
			$horaire3->setDebut( new \Datetime('8:00') );
			$horaire3->setFin( new \Datetime('17:20') );
			$horaire3->setJour( $this->getReference('mercredi') );
			$horaire3->addSemaine( $this->getReference('semaine1-14') );

			$horaire4 = new Horaire;
			$horaire4->setDebut( new \Datetime('8:00') );
			$horaire4->setFin( new \Datetime('17:20') );
			$horaire4->setJour( $this->getReference('jeudi') );
			$horaire4->addSemaine( $this->getReference('semaine1-14') );

			$horaire5 = new Horaire;
			$horaire5->setDebut( new \Datetime('8:00') );
			$horaire5->setFin( new \Datetime('17:20') );
			$horaire5->setJour( $this->getReference('vendredi') );
			$horaire5->addSemaine( $this->getReference('semaine1-14') );

			$coursAppel->addHoraire($horaire1);
			$coursAppel->addHoraire($horaire2);
			$coursAppel->addHoraire($horaire3);
			$coursAppel->addHoraire($horaire4);
			$coursAppel->addHoraire($horaire5);
			$this->addReference('coursAppel', $coursAppel);

		$manager->persist($coursAppel);
		$manager->flush();
	}

	public function getOrder()
	{
		return 5; // l'ordre dans lequel les fichiers sont chargés
	}
}
