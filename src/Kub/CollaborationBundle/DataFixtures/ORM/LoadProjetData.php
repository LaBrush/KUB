<?php

namespace Kub\CollaborationBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Kub\CollaborationBundle\Entity\Projet;
use Kub\CollaborationBundle\Entity\Permission;

class LoadProjetData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
        $projet = new Projet ;
            $projet->setName('Kub');

        $projet->addPermission(
            (new Permission)->setRole(Permission::ADMINISTRATEUR)->setUser( $this->getReference('johnsnow') )
        );

        $manager->persist($projet);
        $manager->flush();

    }

    public function getOrder()
    {
        return 5; // l'ordre dans lequel les fichiers sont chargés
    }
}