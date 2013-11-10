<?php

namespace Kub\ArianeBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Kub\ArianeBundle\Entity\Post;

class LoadPostData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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

        $eleve = $this->getReference('johnsnow');
        $fil = $eleve->getfil();

        $post1 = new Post();
            $post1->setTitre("Premières impressions") ;
            $post1->setContenu("Aujourd'hui j'ai découvert cet ENT que je trouve vraiment super !") ;
            $post1->setDebut(new \DateTime("2013-11-09"));
            $post1->setFin(new \DateTime("2013-11-11"));

        $post2 = new Post();
            $post2->setTitre("Un après midi de folie") ;
            $post2->setContenu("Viens manger avec nous, viens tourner avec nous, viens monter aec nous, on va passer un après-midi de folie !") ;
            $post2->setDebut(new \DateTime("2013-11-06"));
            $post2->setFin(new \DateTime("2013-11-06"));

        $fil->addPost($post1);
        $fil->addPost($post2);

        $manager->persist($fil);
        $manager->flush();

    }

    public function getOrder()
    {
        return 4; // l'ordre dans lequel les fichiers sont chargés
    }
}