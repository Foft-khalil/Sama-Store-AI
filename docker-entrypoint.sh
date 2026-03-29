#!/bin/bash
# Run migrations if we're in production
if [ "$APP_ENV" = "production" ]; then
    echo "Attempting to run migrations..."
    php artisan migrate --force || echo "Migration failed, but continuing to start the server..."
fi

# Optimization: Cache config, routes, and views in production
if [ "$APP_ENV" = "production" ]; then
    echo "Caching configuration and routes..."
    php artisan config:cache || echo "Config cache failed"
    php artisan route:cache || echo "Route cache failed"
    php artisan view:cache || echo "View cache failed"
fi

# Execute the CMD from the Dockerfile
exec "$@"
