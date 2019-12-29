#!/bin/bash

if [ ! -d /var/www/html/vendor ]; then
    cd /var/www/html
    composer install
fi

php-fpm
