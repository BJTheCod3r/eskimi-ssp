
# Eskimi SSP

This is a PHP test task for the role of a PHP Full Stack Developer at Eskimi. It's developed using both Laravel and Vue.

## Setting Up

- git clone this repository

- run `git submodule update --init --recursive` to download laradock

- cd into the laradock directory

- cp the content of **.env.example** to **.env** then set your variables accordingly.

- Before running the command above make sure that all related services to the docker containers in the network should be turned off to avoid conflict in resources (e.g port). Although, you can also change this in the laradock **.env** file.

- Run `docker-compose up -d nginx mysql phpmyadmin redis workspace`

- From your terminal in the laradock directory run `docker-compose exec workspace bash`

- cp the content of **.env.example** to **.env** then set your variables accordingly.

- run `php artisan key:generate` and `php artisan storage:link`

## Running Tests

### Feature Tests

- run `php artisan test` to test the endpoints.

### Browser Tests

To run tests do the following:

- Add a local configuration file for dusk by running the following command inside workspace `cp .env .env.dusk.local`

- Change the APP_URL variable to *localhost:8000*

- Run `php artisan serve --quiet`

- Finally run `php artisan dusk`

## Postman Documentation

https://documenter.getpostman.com/view/7663075/UV5agbQL

## Notes

- You might want to set a different database connection for your tests.

- There is an issue with mac m1 users building mysql on Laradock but there is a fix on this webpage; https://github.com/laradock/laradock/issues/2969#issuecomment-850957533

- All credentials required to access the services in the containers uses laradock default values.


