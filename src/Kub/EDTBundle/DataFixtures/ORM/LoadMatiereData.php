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
			array("Litérrature", "Littérature"),

			array("Mathématiques", "Scientifique"),
			array("SI", "Scientifique"),
			array("Physique", "Scientifique"),

			array("Histoire-Géographie", "Economie et société"),
			array("SES", "Economie et société"),

			array("Anglais", "Langue"),
			array("Espagnol", "Langue"),
			array("Allemand", "Langue"),
			array("Italien", "Langue"),

			array("Musique", "Option"),
			array("Cinéma", "Option"),

			array("Sport", "Autres"),
			array("Autre", "Autres"),
			array("TPE", "Autres"),
			array("Accompagnement personnalisé", "Autres"),
			
			array("PFEG", "Enseignement d'exploration"),
			array("ISN", "Enseignement d'exploration"),
			array("Litérrature et société", "Enseignement d'exploration")
		);

		foreach ($matieres as $prop) {
			$matiere = new Matiere();
			$matiere->setName($prop[0]);
			$matiere->setCategorie( $this->getReference( $prop[1] . '_categorie') );

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