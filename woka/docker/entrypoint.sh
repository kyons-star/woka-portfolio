#!/bin/sh
set -eu

mkdir -p \
    storage/app/private \
    storage/app/public \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

chown -R www-data:www-data \
    storage/app/private \
    storage/framework \
    storage/logs \
    bootstrap/cache
chown www-data:www-data storage/app/public

if [ ! -L public/storage ]; then
    ln -s ../storage/app/public public/storage
fi

exec /usr/bin/supervisord -n -c /etc/supervisor/supervisord.conf
