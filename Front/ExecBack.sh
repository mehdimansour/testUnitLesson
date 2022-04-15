#!/bin/bash
cd Back
docker-compose build
docker-compose up -d
docker-compose exec app bash
composer install
php bin/console doctrine:migration:migrate
php bin/console doctrine:fixtures:load
cat EOF