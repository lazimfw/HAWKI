#!/bin/bash

chmod 777 -Rf ./storage
#start here, copy in docker env
docker compose up --pull always -d
docker compose exec app bash -c "php artisan migrate --force &&
    php artisan db:seed --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan optimize:clear"
#remove \ and line breaks if doesn't work