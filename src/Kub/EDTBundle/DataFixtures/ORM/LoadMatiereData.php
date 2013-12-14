<?php

namespace Kub\EDTBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Kub\EDTBundle\Entity\Matiere;

class LoadMatiereData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
		$matieres = array(
			array("Français", "Langues"),
			array("Litérrature", "Options"),
			array("Mathématiques", "Scientifiques"),
			array("Histoire-Géographie", "Société"),
			array("Anglais", "Langue"),
			array("Espagnol", "Langue"),
			array("Allemand", "Langue"),
			array("Italien", "Langue"),
			array("Musique", "Options"),
			array("Cinéma", "Options"),
			array("Sport", "Autres"),
			array("SI", "Scientifiques"),
			array("SES", "Société"),
			array("PFEG", "Options"),
			array("Physique", "Scientifiques"),
			array("ISN", "Options"),
			array("Matière non repertoriée", "Autres")
		);

		foreach ($matieres as $prop) {
			$matiere = new Matiere();
			$matiere->setName($prop[0]);
			$matiere->setCategorie( $this->getReference( $prop[1]) );

			$this->addReference($matiere->getName(), $matiere);
			$manager->persist($matiere);
		}

		$manager->flush();
	}

	public function getOrder()
	{
		return 1 ;
	}
}