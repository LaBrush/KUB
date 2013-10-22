<?php

namespace Kub\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Kub\UserBundle\Entity\Niveau;


class LoadNiveauData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
        // $manager = $this->container->get("doctrine")->getManager();
        $seconde = new Niveau();
            $seconde->setNom("seconde");
            $seconde->setAnnee("2");

        $premiere = new Niveau();
            $premiere->setNom("premiere");
            $premiere->setAnnee("1");

        $terminale = new Niveau();
            $terminale->setNom("terminale");
            $terminale->setAnnee("0");

        $manager->persist($seconde);
        $manager->persist($premiere);
        $manager->persist($terminale);

        $manager->flush();

        $this->addReference('premiere', $premiere);
    }

    public function getOrder()
    {
        return 1; // l'ordre dans lequel les fichiers sont chargés
    }
}