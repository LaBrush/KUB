<?php

namespace Kub\AbsenceBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Kub\AbsenceBundle\Entity\Appel;
use Kub\AbsenceBundle\Entity\Absence;

class LoadAbsenceData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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

		$cours = $this->getReference('cours') ;
		$eleves = $cours->getEleves();

		foreach ($cours->getHoraires() as $horaire) {

			$appel = new Appel;
			$appel->setHoraire($horaire);

			$nb = rand(0, count($eleves)/3 );
			for ($i=0; $i < $nb ; $i++) { 
				
				$absence = new Absence ;
					$absence->setType( Absence::ABSENCE );
					$absence->setStatut( Absence::ATTENTE );

					$absence->setEleve($eleves[ rand(0, count($eleves)-1) ]);
					$absence->setAppel($appel);

				$manager->persist($absence);
			}

			$manager->persist($appel);
		}

		$manager->flush();

	}

	public function getOrder()
	{
		return 5; // l'ordre dans lequel les fichiers sont chargés
	}
}