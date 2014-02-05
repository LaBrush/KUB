<?php

namespace Kub\ArianeBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Kub\ArianeBundle\Entity\Commentaire;

class LoadCommentaireData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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

        $professeur = $this->getReference('jean-sebastienbach');
        $post = $this->getReference('post_ariane');

        $commentaire = new Commentaire();
            $commentaire->setAuteur($professeur);
            $commentaire->setPost($post);
            $commentaire->setContenu("J'adore cette musique ! Tudududu...");


        $manager->persist($commentaire);
        $manager->flush();

    }

    public function getOrder()
    {
        return 5; // l'ordre dans lequel les fichiers sont chargés
    }
}