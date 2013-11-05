<?php

namespace Kub\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Kub\UserBundle\Entity\Tuteur;


class LoadTuteurData implements FixtureInterface, ContainerAwareInterface
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
        $discriminator->setClass('Kub\UserBundle\Entity\Tuteur');

        $userManager = $this->container->get('pugx_user_manager');
        
        $tuteur1 = $userManager->createUser();

        $tuteur1->setNom('Curie');
        $tuteur1->setPrenom('Marie');

        $tuteur1->setEmail('cmarie@mail.com');
        $tuteur1->setPlainPassword('adrien');
        $tuteur1->setEnabled(true);

        $tuteur2->setNom('Marin');
        $tuteur2->setPrenom('Martin');

        $tuteur2->setEmail('mmarin@mail.com');
        $tuteur2->setPlainPassword('adrien');
        $tuteur2->setEnabled(true);

        $userManager->updateUser($tuteur1, true);
        $userManager->updateUser($tuteur2, true);
    }
}