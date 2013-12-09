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
		$categoriesName = array(
			"Littérature",
			"Scientifique",
			"Economie et société",
			"Langue",
			"Nouilles aux andouillettes",
			"Art",
			"Autre"
		);

		$categories = array();
		foreach ($categories as $key => $name) {
			$categorie = new Categorie();
			$categorie->setNom($name);

			$categories[$name] = $categorie ;

			$manager->persist($categorie);
		}

		$this->addReference("matieres_categories", $categories);
		$manager->flush();
	}

	public function getOrder()
	{
		return 0 ;
	}
}