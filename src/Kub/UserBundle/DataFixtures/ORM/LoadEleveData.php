<?

namespace Kub\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Kub\UserBundle\Entity\Eleve;


class LoadEleveData implements FixtureInterface, ContainerAwareInterface
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
        $discriminator = $this->container->get('pugx_user.manager.user_discriminator');
        $discriminator->setClass('Kub\UserBundle\Entity\Eleve');

        $userManager = $this->container->get('pugx_user_manager');
        $eleve = $userManager->createUser();

        $eleve->setUsername('johnsnow');
        $eleve->setNom('John');
        $eleve->setPrenom('snow');
        $eleve->setAnniversaire(new \Datetime());

        $eleve->setEmail('admin@mail.com');
        $eleve->setPlainPassword('123456');
        $eleve->setEnabled(true);

        $userManager->updateUser($eleve, true);

        $discriminator->setClass('Kub\UserBundle\Entity\Administrateur');

        $userManager = $this->container->get('pugx_user_manager');
        $manitou = $userManager->createUser();

        $manitou->setUsername('tonystark');
        $manitou->setNom('Stark');
        $manitou->setPrenom('Tony');

        $manitou->addRole("ROLE_MANITOU");

        $manitou->setEmail('tonystrack@mail.com');
        $manitou->setPlainPassword('123456');
        $manitou->setEnabled(true);

        $userManager->updateUser($manitou, true);
    }
}