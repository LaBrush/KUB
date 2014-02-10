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
		$cours = new Cours;
			$cours->setProfesseur( $this->getReference('professeur') );
			$cours->addGroupe( $this->getReference('si3') );
			$cours->setMatiere( $this->getReference('Anglais') );

			$horaire1 = new Horaire;
			$horaire1->setDebut( new \Datetime('08:00') );
			$horaire1->setFin( new \Datetime('10:00') );
			$horaire1->setJour( $this->getReference('lundi') );
			$horaire1->addSemaine( $this->getReference('semaine10-2014') );

			$horaire2 = new Horaire;
			$horaire2->setDebut( new \Datetime('13:25') );
			$horaire2->setFin( new \Datetime('16:20') );
			$horaire2->setJour( $this->getReference('mardi') );
			$horaire2->addSemaine( $this->getReference('semaine10-2014') );

			$horaire3 = new Horaire;
			$horaire3->setDebut( new \Datetime('16:20') );
			$horaire3->setFin( new \Datetime('17:20') );
			$horaire3->setJour( $this->getReference('mardi') );
			$horaire3->addSemaine( $this->getReference('semaine10-2014') );

			$cours->addHoraire($horaire1);
			$cours->addHoraire($horaire2);
			$cours->addHoraire($horaire3);
			$this->addReference('cours', $cours);

		$manager->persist($cours);
		$manager->flush();
	}

	public function getOrder()
	{
		return 5; // l'ordre dans lequel les fichiers sont chargés
	}
}