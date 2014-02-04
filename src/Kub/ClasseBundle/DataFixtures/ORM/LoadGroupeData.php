<?php

namespace Kub\ClasseBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Kub\ClasseBundle\Entity\Groupe;


class LoadGroupeData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
		$si3 = new Groupe();
			$si3->setName("SI-3");
			$si3->setNiveau($this->getReference('premiere'));

		$this->addReference('si3', $si3);

		$manager->persist($si3);
		$manager->flush();

		$groupes = array(

			"seconde" => array(
				"1",
				"2",
				"3",
				"4",
				"5",
				"cinema",
				"isn",
				"musique"
			),
			"premiere" => array(
				"SI",
				"S1",
				"S2",
				"ES1",
				"ES2",
				"L",
				"cinema",
				"musique"
			),
			"terminale" => array(
				"SI",
				"S1",
				"S2",
				"ES1",
				"ES2",
				"L",
				"cinema",
				"musique"
			)
		);

		foreach ($groupes as $niveau => $liste) {
			foreach ($liste as $name) {

				$groupe = new Groupe();
					$groupe->setName($name);
					$groupe->setNiveau($this->getReference($niveau));

				$manager->persist($groupe);
				$this->addReference($niveau . $groupe->getName(), $groupe);
			}
		}

		$manager->flush();
	}

	public function getOrder()
	{
		return 1; //l'ordre dans lequel les fichiers sont chargés
	}
}