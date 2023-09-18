# Symfony Weather App

Simple weather app built on the [Symfony 6.3.4](https://symfony.com) web framework.

## Features

* Docker environment ready to use
* Two APIs for forecast data (OpenWeatherMap.org and WeatherAPI.com)
* Common interface and trait for easier integrations of other APIs
* Self-hosted Sentry integration
* Redis caching (SncRedisBundle)
* GitHub Actions workflow (build Docker images, validate Composer packages)
* Error handling (HTTP response codes and exceptions)
* Saving all requests in the database (PostgreSQL)

<img src="https://i.imgur.com/nV5rUGQ.png" width="450" alt="screenshot"/>

## Requirements
* [Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)

## How to use

1. Run `docker compose build --no-cache` to build fresh images
2. Run `docker compose up --pull --wait -d` to start the project
3. Run `docker compose exec php sh` to enter the shell
4. Create database: `php bin/console doctrine:database:create`
5. Apply migrations: `php bin/console doctrine:migrations:migrate`
6. Open `https://localhost/weather` in your web browser
7. Exit the shell and run `docker compose down --remove-orphans` to stop the Docker containers.
