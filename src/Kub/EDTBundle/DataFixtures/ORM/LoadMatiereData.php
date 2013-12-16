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
			array("Français", "Litérrature"),
			array("Litérrature et Société", "Litérrature"),
			array("Mathématiques", "Sciences"),
			array("Histoire-Géographie", "Société"),
			array("Anglais", "Langues"),
			array("Espagnol", "Langues"),
			array("Allemand", "Langues"),
			array("Italien", "Langues"),
			array("Musique", "Art"),
			array("Cinéma", "Art"),
			array("Sport", "Autres"),
			array("SI", "Sciences"),
			array("SES", "Société"),
			array("PFEG", "Société"),
			array("Physique", "Sciences"),
			array("ISN", "Sciences"),
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