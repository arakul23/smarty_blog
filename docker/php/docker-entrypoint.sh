#!/bin/sh
set -e

if [ ! -d "vendor" ]; then
    echo "Vendor folder is empty. Installing dependencies..."
    composer install --no-interaction --optimize-autoloader
else
    echo "Vendor folder exists. Syncing..."
    composer install --no-interaction --optimize-autoloader
fi

exec "$@"