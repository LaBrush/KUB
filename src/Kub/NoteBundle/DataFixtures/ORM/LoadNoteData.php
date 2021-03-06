<?php

namespace Kub\NoteBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Kub\NoteBundle\Entity\Note;


class LoadNoteData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
        $note1 = new Note ;
            $note1->setNote('15');
            $note1->setCoefficient('20');
            $note1->setEleve( $this->getReference('johnsnow') );


        $note2 = new Note ;
            $note2->setNote('17');
            $note2->setCoefficient('20');
            $note2->setEleve( $this->getReference('deneristhargarien') );

        $this->addReference('note1', $note1);
        $this->addReference('note2', $note2);

        $manager->persist( $note1 );
        $manager->persist( $note2 );

        $manager->flush();
    }

    public function getOrder()
    {
        return 6; // l'ordre dans lequel les fichiers sont chargés
    }
}