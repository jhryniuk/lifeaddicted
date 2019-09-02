#!/usr/bin/env bash

function helper
{
    echo -e "Available arguments:"
    echo -e "'build' - builds docker environment"
    echo -e "'run' - runs docker environment"
    echo -e "'down' - shut down docker environment"
}

function build
{
    docker-compose build --no-cache
}

function run
{
    docker-compose up -d
}

function down
{
    docker-compose down
}

case $1 in
    'build')
        build
        ;;
    'run')
        run
        ;;
    'down')
        down
        ;;
    *)
        helper
        ;;
esac