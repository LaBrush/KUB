php app/console cache:clear

php app/console doctrine:query:sql "DROP DATABASE IF EXISTS kub"
php app/console doctrine:database:create

php app/console doctrine:generate:entities KubArianeBundle --no-backup
php app/console doctrine:generate:entities KubAgendaBundle --no-backup
php app/console doctrine:generate:entities KubAbsenceBundle --no-backup
php app/console doctrine:generate:entities KubCasierBundle --no-backup
php app/console doctrine:generate:entities KubClasseBundle --no-backup
php app/console doctrine:generate:entities KubCollaborationBundle --no-backup
php app/console doctrine:generate:entities KubEDTBundle --no-backup
php app/console doctrine:generate:entities KubHomeBundle --no-backup
php app/console doctrine:generate:entities KubNoteBundle --no-backup
php app/console doctrine:generate:entities KubRessourceBundle --no-backup
php app/console doctrine:generate:entities KubUserBundle --no-backup
php app/console doctrine:generate:entities KubNotificationBundle --no-backup

php app/console doctrine:schema:update --force
php app/console doctrine:fixtures:load
php app/console cache:clear
