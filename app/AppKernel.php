<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {

        date_default_timezone_set("Europe/Paris");

        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new JMS\AopBundle\JMSAopBundle(),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
            new JMS\DiExtraBundle\JMSDiExtraBundle($this),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new FOS\MessageBundle\FOSMessageBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new PUGX\MultiUserBundle\PUGXMultiUserBundle(),
            new Misd\PhoneNumberBundle\MisdPhoneNumberBundle(),
            new Genemu\Bundle\FormBundle\GenemuFormBundle(),
            new Kub\HomeBundle\KubHomeBundle(),
            new Kub\UserBundle\KubUserBundle(),
            new Kub\NoteBundle\KubNoteBundle(),
            new Kub\ArianeBundle\KubArianeBundle(),
            new Kub\CollaborationBundle\KubCollaborationBundle(),
            new Kub\AbsenceBundle\KubAbsenceBundle(),
            new Kub\RessourceBundle\KubRessourceBundle(),
            new Kub\ClasseBundle\KubClasseBundle(),
            new Kub\EDTBundle\KubEDTBundle(),
            new Kub\NotificationBundle\KubNotificationBundle(),
            new Kub\MessageBundle\KubMessageBundle(),
            new Kub\MessagerieBundle\KubMessagerieBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
