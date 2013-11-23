rem php ./composer.phar update
php app/console cache:clear

php app/console doctrine:query:sql "DROP DATABASE IF EXISTS kub"
php app/console doctrine:database:create

php app/console doctrine:generate:entities KubArianeBundle
php app/console doctrine:generate:entities KubAgendaBundle
php app/console doctrine:generate:entities KubAbsenceBundle
php app/console doctrine:generate:entities KubCasierBundle
php app/console doctrine:generate:entities KubClasseBundle
php app/console doctrine:generate:entities KubCollaborationBundle
php app/console doctrine:generate:entities KubEDTBundle
php app/console doctrine:generate:entities KubHomeBundle
php app/console doctrine:generate:entities KubNotesBundle
php app/console doctrine:generate:entities KubNotificationBundle
php app/console doctrine:generate:entities KubRessourceBundle
php app/console doctrine:generate:entities KubUserBundle

rem php app/console doctrine:schema:update --dump-sql
php app/console doctrine:schema:update --force
php app/console doctrine:fixtures:load 
php app/console cache:clear
