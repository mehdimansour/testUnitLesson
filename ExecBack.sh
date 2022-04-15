#!/bin/bash
cd Back

docker-compose build
docker-compose up -d
docker-compose exec -T app composer install
docker-compose exec -T app php bin/console doctrine:migration:migrate
docker-compose exec -T app php bin/console doctrine:fixtures:load
docker-compose exec -T app php bin/console doctrine:database:drop --force --env=test
docker-compose exec -T app php bin/console doctrine:database:create --env=test
docker-compose exec -T app php bin/console doctrine:migrations:migrate -n --env=test
docker-compose exec -T app ./vendor/bin/phpunit
docker-compose exec -T app XDEBUG_MODE=coverage ./vendor/bin/phpunit  --coverage-text=out/coverage.txt
