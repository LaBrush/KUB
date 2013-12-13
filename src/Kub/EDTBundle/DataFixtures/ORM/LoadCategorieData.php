<?php

namespace Kub\EDTBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Kub\EDTBundle\Entity\Categorie;

class LoadCategorieData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
		$categories = array(
			"Littérature",
			"Scientifique",
			"Economie et société",
			"Langue",
			"Nouilles aux andouillettes",
			"Art",
			"Autres"
		);

		foreach ($categories as $name) {
			$categorie = new Categorie();
			$categorie->setNom($name);

			$this->addReference($name, $categorie);
			$manager->persist($categorie);
		}

		$manager->flush();
	}

	public function getOrder()
	{
		return 0 ;
	}
}