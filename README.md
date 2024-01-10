# Review Instructions

## Environment setup
```
docker-compose up -d
```

Exec in to the docker container

```
docker exec -it [PHP_FPM_CONTAINER_NAME] /bin/bash
```

Run package manager

```
composer install
```

## Running tests

Exec in to the docker container

```
docker exec -it [PHP_FPM_CONTAINER_NAME] /bin/bash
```

Run PHPUnit

```
./vendor/bin/phpunit
```

Can also see test coverage with the following command (still inside the container)
```
XDEBUG_MODE=coverage ./vendor/bin/phpunit --coverage-text
```

## Simple view

Navigate to the following URL to see a simple output of the work.

```
http://localhost:4000/
```