<?php

namespace Kub\EDTBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Kub\EDTBundle\Entity\Matiere;

class LoadMatiereData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
        $matieresNames = array(
            "Francais",
            "Mathématiques",
            "Anglais",
            "Espagnol",
            "Cinéma",
            "Allemand",
            "Musique",
            "Italien",
            "SI",
            "SES",
            "PFEG",
            "Physique",
            "Litérrature",
            "ISN",
            "Autre"
        );

        foreach ($matieresNames as $key => $name) {
            $matiere = new Matiere();
            $matiere->setName($name);

            $this->addReference($name, $matiere);
            $manager->persist($matiere);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 0 ;
    }
}