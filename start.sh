#!/bin/bash
set -e

cd /app/leboncoin

echo "Running migrations..."
php artisan migrate --force || true

echo "Clearing caches..."
php artisan config:cache
php artisan route:cache

echo "Starting Laravel on port $PORT..."
php artisan serve --host=0.0.0.0 --port=$PORT
