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

            $horaire1 = $cours->getHoraires()[0];
            $horaire1->setDebut( new \Datetime('07:55') );
            $horaire1->setFin( new \Datetime('10:05') );
            $horaire1->setJour( $this->getReference('lundi') );
            $horaire1->addSemaine( $this->getReference('semaine49') );

            $cours->addHoraire($horaire1);

            $horaire2 = new Horaire();
            $cours->addHoraire($horaire2);
            $horaire2->setDebut( new \Datetime('09:50') );
            $horaire2->setFin( new \Datetime('11:55') );
            $horaire2->setJour( $this->getReference('lundi') );
            $horaire2->addSemaine( $this->getReference('semaine49') );

            $cours->addHoraire($horaire2);

            $horaire3 = new Horaire();
            $cours->addHoraire($horaire3);
            $horaire3->setDebut( new \Datetime('12:50') );
            $horaire3->setFin( new \Datetime('15:55') );
            $horaire3->setJour( $this->getReference('mardi') );
            $horaire3->addSemaine( $this->getReference('semaine49') );

            $cours->addHoraire($horaire3);

        $manager->persist($cours);
        $manager->flush();
    }

    public function getOrder()
    {
        return 5; // l'ordre dans lequel les fichiers sont chargés
    }
}