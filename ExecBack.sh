#!/bin/bash
cd Back
docker-compose build
docker-compose up -d
docker-compose exec -T container pwd "composer install"
docker-compose exec -T container pwd "php bin/console doctrine:migration:migrate"
docker-compose exec -T container pwd "php bin/console doctrine:fixtures:load"
docker-compose exec -T container pwd "./vendor/bin/phpunit"
