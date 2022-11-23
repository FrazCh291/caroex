### Project one time setup
```
$ sudo docker-compose up -d --build
$ sudo docker-compose exec php bash
$ composer install
$ npm install
$ npm run prod [dev|prod]
$ php artisan key:generate
$ php artisan migrate --seed
$ php artisan storage:link
$ php artisan serve
```

### Project update
```
$ composer install
$ npm install
$ npm run prod [dev|prod]
$ composer dumpautoload
$ php artisan migrate --seed
```
