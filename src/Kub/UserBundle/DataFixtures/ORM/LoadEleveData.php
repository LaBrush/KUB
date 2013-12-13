<?php

namespace Kub\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;


use Kub\UserBundle\Entity\Eleve;


class LoadEleveData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
		$discriminator = $this->container->get('pugx_user.manager.user_discriminator');
		$discriminator->setClass('Kub\UserBundle\Entity\Eleve');

		$userManager = $this->container->get('pugx_user_manager');
		$johnsnow = $userManager->createUser();

		$johnsnow->setNom('Snow');
		$johnsnow->setPrenom('John');
		$johnsnow->setAnniversaire(new \Datetime());
		$johnsnow->setNiveau($this->getReference('premiere'));

		$johnsnow->setEmail('admin@mail.com');
		$johnsnow->setPlainPassword('123456');
		$johnsnow->setEnabled(true);

		$this->addReference('johnsnow', $johnsnow);
		$userManager->updateUser($johnsnow, true);

		$deneris = $userManager->createUser();

		$deneris->setNom('Thargarien');
		$deneris->setPrenom('Deneris');
		$deneris->setAnniversaire(new \Datetime());
		$deneris->setNiveau($this->getReference('premiere'));

		$deneris->setEmail('adfdmin@mail.com');
		$deneris->setPlainPassword('123456');
		$deneris->setEnabled(true);

		$this->addReference('deneristhargarien', $deneris);
		$userManager->updateUser($deneris, true);
	}

	public function getOrder()
	{
		return 2; // l'ordre dans lequel les fichiers sont chargés
	}
}