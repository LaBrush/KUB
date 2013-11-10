<?php

namespace Kub\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;


use Kub\UserBundle\Entity\Professeur;


class LoadProfesseurData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
        $discriminator->setClass('Kub\UserBundle\Entity\Professeur');

        $userManager = $this->container->get('pugx_user_manager');
        $professeur = $userManager->createUser();

        $professeur->setNom('Bach');
        $professeur->setPrenom('Jean-Sebastien');

        $professeur->setEmail('admina@mail.com');
        $professeur->setPlainPassword('123456');
        $professeur->setEnabled(true);

        $this->addReference('professeur', $professeur);

        $userManager->updateUser($professeur, true);
    }

    public function getOrder()
    {
        return 2; // l'ordre dans lequel les fichiers sont chargés
    }
}