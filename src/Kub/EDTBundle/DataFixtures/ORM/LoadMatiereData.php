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
			array("Français", "Littérature"),
			array("Mathématiques", "Scientifique"),
			array("Histoire-Géographie", "Economie et société"),
			array("Anglais", "Langue"),
			array("Espagnol", "Langue"),
			array("Cinéma", "Nouilles aux andouillettes"),
			array("Allemand", "Langue"),
			array("Musique", "Art"),
			array("Italien", "Langue"),
			array("Sport", "Autre"),
			array("SI", "Scientifique"),
			array("SES", "Economie et société"),
			array("PFEG", "Economie et société"),
			array("Physique", "Scientifique"),
			array("SI", "Scientifique"),
			array("Litérrature", "Littérature"),
			array("ISN", "Nouilles aux andouillettes"),
			array("Autre", "Autre")
		);

		$categories = $this->getReference('matieres_categories');
		foreach ($matieres as $prop) {
			$matiere = new Matiere();
			$matiere->setName($prop[0]);
			echo $matiere->getName();
			$matiere->setCategorie( $categories[$prop[1]] );

			$this->addReference($name, $matiere);
			$manager->persist($matiere);
		}

		$manager->flush();
	}

	public function getOrder()
	{
		return 0 ;
	}
}