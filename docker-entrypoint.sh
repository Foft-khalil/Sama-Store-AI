#!/bin/bash
set -e

# Run migrations if we're in production
if [ "$APP_ENV" = "production" ]; then
    echo "Running migrations..."
    php artisan migrate --force
fi

# Optimization: Cache config, routes, and views in production
if [ "$APP_ENV" = "production" ]; then
    echo "Caching configuration and routes..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

# Execute the CMD from the Dockerfile
exec "$@"
