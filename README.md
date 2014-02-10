The Kub by LabRush
==================

Welcome on the Kub, made by Nathan Rajonhson and Adrien Bocquet.
Kub is a numeric work space we do for an highschool project.

This document contains information on how to download, install, and start
using the Kub.

1) Install the vendors and set up the database
----------------------------------------------

First you have to change the file parameters.yml.dist and set him to parameters.yml
Then open it and complete the informations with the right answers.

If you downloaded an archive "without vendors", you also need to install all
the necessary dependencies. Download composer (see above) and run the
following command:

    php composer.phar install

To set up the database, run the maintenance.bash for Unix system (Linux, OS X)
and the maintenance.bat for Window system:

	./maintenance.bash

2) Checking your System Configuration
-------------------------------------

Before starting coding, make sure that your local system is properly
configured for Symfony.

Execute the `check.php` script from the command line:

    php app/check.php

The script returns a status code of `0` if all mandatory requirements are met,
`1` otherwise.

Access the `config.php` script from a browser:

    http://localhost/path/to/symfony/app/web/config.php

If you get any warnings or recommendations, fix them before moving on.


What's inside?
---------------

The Kub project is based on the Symfony Framework
It also includes sass files, and uses jQuery

Inside Symfony, you'll find the following bundles (or component):
 - SymfonyFrameworkBundle
 - SymfonySecurityBundle
 - SymfonyTwigBundle
 - SymfonyMonologBundle
 - SymfonySwiftmailerBundle
 - AsseticBundle
 - DoctrineBundle
 - DoctrineDoctrineFixturesBundle
 - StofDoctrineExtensionsBundle
 - SensioFrameworkExtraBundle
 - JMSAopBundle
 - JMSSecurityExtraBundle
 - JMSDiExtraBundle
 - JMSSerializerBundle
 - FOSUserBundle
 - KnpMenuBundle
 - PUGXMultiUserBundle
 - MisdPhoneNumberBundle
 - GenemuFormBundle

All libraries and bundles included in the Symfony Standard Edition are
released under the MIT or BSD license.

Enjoy!


