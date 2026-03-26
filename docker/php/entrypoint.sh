#!/bin/bash

# Iniciar o cron em background
service cron start

# Rodar o comando original do container (ex: php-fpm)
exec "$@"
