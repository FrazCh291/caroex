docker system prune --force
docker-compose up -d
docker-compose stop supervisor
#docker-compose exec -T php composer dump-autoload
#docker-compose exec -T php composer install
docker-compose exec -T php php artisan migrate --force
docker-compose exec -T php php artisan db:seed --class=CurrencySeeder --force
#docker-compose exec -T php npm run prod
docker-compose exec -T php php artisan schedule:run
docker-compose start supervisor
