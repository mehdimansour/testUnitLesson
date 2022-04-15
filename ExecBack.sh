#!/bin/bash
cd Back

docker-compose build
docker-compose up -d
docker-compose exec -T app "composer install"
docker-compose exec -T app "php bin/console doctrine:migration:migrate"
docker-compose exec -T app "php bin/console doctrine:fixtures:load"
docker-compose exec -T app "./vendor/bin/phpunit"
