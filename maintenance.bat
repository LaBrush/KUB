# php ./composer.phar update ;
php app/console cache:clear ;

php app/console doctrine:query:sql "DROP DATABASE IF EXISTS kub" ;
php app/console doctrine:database:create ;

php app/console doctrine:generate:entities Kub ;
# php app/console doctrine:schema:update --dump-sql ;
php app/console doctrine:schema:update --force ;
php app/console doctrine:fixtures:load 
php app/console cache:clear ;
