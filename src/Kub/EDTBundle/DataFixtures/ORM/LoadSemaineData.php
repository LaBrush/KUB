<?php

namespace Kub\EDTBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Kub\EDTBundle\Entity\Semaine;


class LoadSemaineData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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

        for($y=14 ; $y <= 15 ; $y++)
        {
            for ($i=1; $i <= 52 ; $i++) { 

                $semaine = new Semaine();
                    $semaine->setNumero($i);
                    $semaine->setAnnee($y);

                $this->addReference('semaine'.$i.'-'.$y, $semaine);
                $manager->persist($semaine);
            }
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 0 ;
    }
}