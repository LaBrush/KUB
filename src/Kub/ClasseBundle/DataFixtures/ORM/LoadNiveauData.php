<?php

namespace Kub\ClasseBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Kub\ClasseBundle\Entity\Niveau;


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
            $seconde->setName("seconde");
            $seconde->setAnnee("2");
            $seconde->setAbreviation("2nd");

        $premiere = new Niveau();
            $premiere->setName("premiere");
            $premiere->setAnnee("1");
            $premiere->setAbreviation("1ere");

        $terminale = new Niveau();
            $terminale->setName("terminale");
            $terminale->setAnnee("0");
            $terminale->setAbreviation("term");

        $manager->persist($seconde);
        $manager->persist($premiere);
        $manager->persist($terminale);

        $manager->flush();

        $this->addReference('seconde', $seconde);
        $this->addReference('premiere', $premiere);
        $this->addReference('terminale', $terminale);
    }

    public function getOrder()
    {
        return 0; // l'ordre dans lequel les fichiers sont chargés
    }
}