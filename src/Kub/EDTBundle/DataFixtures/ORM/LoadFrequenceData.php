<?php

namespace Kub\EDTBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Kub\EDTBundle\Entity\Frequence;
use Kub\EDTBundle\Entity\Semaine;

class LoadFrequenceData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
        $listeSemaines = $this->container->get('doctrine.orm.default_entity_manager')->getRepository("KubEDTBundle:Semaine")->findAll();

        $everyWeek = new Frequence();
            $everyWeek->setName("Toutes les semaines");

        foreach ($listeSemaines as $key => $semaine) {
            $everyWeek->addSemaine($semaine);
        }

        $manager->persist($everyWeek);
        $manager->flush();
    }

    public function getOrder()
    {
        return 1 ;
    }
}