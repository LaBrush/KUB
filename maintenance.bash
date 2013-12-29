cd /Users/adrienbocquet/Sites/MAMP/KUB/ ;

# ./composer.phar update ;
app/console cache:clear ;

app/console doctrine:query:sql "DROP DATABASE IF EXISTS kub" ;
app/console doctrine:database:create ;

app/console doctrine:generate:entities KubArianeBundle 			--no-backup ;
app/console doctrine:generate:entities KubAbsenceBundle 		--no-backup ;
app/console doctrine:generate:entities KubClasseBundle 			--no-backup ;
app/console doctrine:generate:entities KubCollaborationBundle 	--no-backup ;
app/console doctrine:generate:entities KubEDTBundle 			--no-backup ;
app/console doctrine:generate:entities KubHomeBundle 			--no-backup ;
app/console doctrine:generate:entities KubNoteBundle 			--no-backup ;
app/console doctrine:generate:entities KubNotificationBundle 	--no-backup ;
app/console doctrine:generate:entities KubRessourceBundle 		--no-backup ;
app/console doctrine:generate:entities KubUserBundle 			--no-backup ;

# app/console doctrine:schema:update --dump-sql ;
app/console doctrine:schema:update --force ;
app/console doctrine:fixtures:load 
app/console cache:clear ;

echo "Maintenance terminée !" ;