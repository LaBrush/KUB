<?php

namespace Kub\EDTBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Kub\EDTBundle\Entity\Cours;
use Kub\EDTBundle\Entity\Horaire;


class LoadCoursData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
        $cours = new Cours;
            $cours->setProfesseur( $this->getReference('professeur') );
            $cours->addGroupe( $this->getReference('si3') );
            $cours->setMatiere( $this->getReference('Anglais') );

            $horaire = $cours->getHoraires()[0];
            $horaire->setDebut( new \Datetime('07:55') );
            $horaire->setFin( new \Datetime('10:05') );
            $horaire->setJour( $this->getReference('lundi') );
            $horaire->addSemaine( $this->getReference('semaine49') );

            $cours->addHoraire($horaire);

        $manager->persist($cours);
        $manager->flush();
    }

    public function getOrder()
    {
        return 5; // l'ordre dans lequel les fichiers sont chargés
    }
}