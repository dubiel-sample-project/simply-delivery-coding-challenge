# simply-delivery-coding-challenge
 
### Api for items and their properties ###

## Installation and Setup

The api architecture consists of three services (nginx, php and mysql) all managed by Docker. 

1. After checking out the repository, run `docker-compose up -d --build` to create the service containers.
2. After successfully building, log into the php container using `docker exec -it {php_container_name} bash`
3. From the root directory (/var/www/symfony) run `composer install` to install packages from the composer.lock file. If composer can not be found there is a shell script `composer_install.sh` to install it
4. After installation, the api should be available from port 8001 at localhost
5. A dump file is provided in the mysql service but database fixtures can also be loaded using `bin/console doctrine:fixtures:load`

## Overview

The documentation for the api can be found at `/api/doc`

There is a make file in the root directory for running the tests which can be executed using `make tests`