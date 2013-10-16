<?php

namespace Kub\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Kub\UserBundle\Entity\Eleve;


class LoadEleveData implements FixtureInterface, ContainerAwareInterface
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
        $eleve = $userManager->createUser();

        $eleve->setNom('Snow');
        $eleve->setPrenom('John');
        $eleve->setAnniversaire(new \Datetime());

        $eleve->setEmail('admin@mail.com');
        $eleve->setPlainPassword('123456');
        $eleve->setEnabled(true);

        $userManager->updateUser($eleve, true);
    }
}