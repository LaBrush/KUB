<?php

namespace Kub\NoteBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Kub\NoteBundle\Entity\Controle;


class LoadControleData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
        $controle = new Controle ;
            $controle->setCours( $this->getReference('cours') );
            $controle->setNom('Evaluation sur les vecteurs');

            $controle->addNote( $this->getReference('note1') );
            $controle->addNote( $this->getReference('note2') );        

        $manager->persist( $controle );
        $manager->flush();
    }

    public function getOrder()
    {
        return 7; // l'ordre dans lequel les fichiers sont chargés
    }
}