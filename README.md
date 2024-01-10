# Review Instructions

## Environment setup
```
docker-compose up -d
```

Exec in to the docker container

```
docker exec -it php-basket-php-fpm-1 /bin/bash
```

Run package manager

```
composer install
```

## Running tests

Exec in to the docker container

```
docker exec -it php-basket-php-fpm-1 /bin/bash
```

Run PHPUnit

```
./vendor/bin/phpunit
```

Can also see code coverage with the following command (atill inside the container)
```
XDEBUG_MODE=coverage ./vendor/bin/phpunit --coverage-text
```

## Simple view

Navigate to the following URL to see a simple output of the work.

```
http://localhost:4000/
```