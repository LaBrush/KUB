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
        // $manager = $this->container->get("doctrine")->getManager();
        $premiere = new Groupe();
            $premiere->setName("SI-3");
            $premiere->setNiveau($this->getReference('premiere'));
            $premiere->addEleve($this->getReference('johnsnow'));

        $manager->persist($premiere);

        $manager->flush();
    }

    public function getOrder()
    {
        return 4; // l'ordre dans lequel les fichiers sont chargés
    }
}