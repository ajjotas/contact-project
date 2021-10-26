# How to run:

You have the option to run locally or using Docker.

## Run using docker:
**What you need installed:** Docker

On a *command prompt*, run *docker-compose up -d --build* at the project root.

The application will start running on *http://localhost:8000*.

## Run locally, without docker:
**What you need installed:** PHP version 7.2 or higher, Composer v2.1.8

At the project root, run  the command *composer install*.

Delete any files in the *bootstrap/cache* directory.

Run *php artisan serve*.

The application will start running on *http://localhost:8000*.
