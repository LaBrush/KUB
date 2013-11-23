cd /Users/adrienbocquet/Sites/MAMP/KUB/ ;

# ./composer.phar update ;
app/console cache:clear ;

app/console doctrine:query:sql "DROP DATABASE IF EXISTS kub" ;
app/console doctrine:database:create ;

app/console doctrine:generate:entities KubArianeBundle ;
app/console doctrine:generate:entities KubAgendaBundle ;
app/console doctrine:generate:entities KubAbsenceBundle ;
app/console doctrine:generate:entities KubCasierBundle ;
app/console doctrine:generate:entities KubClasseBundle ;
app/console doctrine:generate:entities KubCollaborationBundle ;
app/console doctrine:generate:entities KubEDTBundle ;
app/console doctrine:generate:entities KubHomeBundle ;
app/console doctrine:generate:entities KubNotesBundle ;
app/console doctrine:generate:entities KubNotificationBundle ;
app/console doctrine:generate:entities KubRessourceBundle ;
app/console doctrine:generate:entities KubUserBundle ;

# app/console doctrine:schema:update --dump-sql ;
app/console doctrine:schema:update --force ;
app/console doctrine:fixtures:load 
app/console cache:clear ;

echo "Maintenance terminée !" ;