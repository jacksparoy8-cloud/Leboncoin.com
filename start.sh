#!/bin/bash
set -e

echo "=== Railway Laravel Deploy ==="
cd /app/leboncoin

echo "Setting permissions..."
chmod -R 755 storage bootstrap/cache
chmod -R 777 storage bootstrap/cache

echo "Running migrations..."
php artisan migrate --force || true

echo "Clearing caches..."
php artisan config:cache
php artisan route:cache

echo "Starting Laravel on port $PORT..."
exec php artisan serve --host=0.0.0.0 --port=$PORT
