<?php

namespace Kub\RessourceBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Kub\RessourceBundle\Entity\Ressource;

class LoadRessourceData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
        $professeur = $this->getReference('professeur');

        $ressource = new Ressource();
            $ressource->setType("web");
            $ressource->setDescription('Voici un billet en rapport avec le Kub');
            $ressource->setAuteur($professeur);
            $ressource->setTitre("L'histoire du Kub");
            $ressource->setUrl("http://legarsdacote.tumblr.com/kub");


        $manager->persist($ressource);
        $manager->flush();

    }

    public function getOrder()
    {
        return 5; // l'ordre dans lequel les fichiers sont chargés
    }
}