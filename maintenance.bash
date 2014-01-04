cd /Users/adrienbocquet/Sites/MAMP/KUB/ ;

# ./composer.phar update ;
app/console cache:clear ;

app/console doctrine:query:sql "DROP DATABASE IF EXISTS kub" ;
app/console doctrine:database:create ;

app/console doctrine:generate:entities Kub --no-backup ;

# app/console doctrine:schema:update --dump-sql ;
app/console doctrine:schema:update --force ;
app/console doctrine:fixtures:load 
app/console cache:clear ;

echo "Maintenance terminée !" ;