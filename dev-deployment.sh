docker system prune --force
docker-compose up -d
docker-compose stop supervisor_dev
#docker-compose exec -T php composer dump-autoload
#docker-compose exec -T php composer install
docker-compose exec -T php_dev php artisan migrate --force
docker-compose exec -T php_dev php artisan db:seed --class=CurrencySeeder --force
#docker-compose exec -T php npm run prod
docker-compose exec -T php_dev php artisan schedule:run
docker-compose start supervisor_dev
