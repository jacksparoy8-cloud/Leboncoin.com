#!/bin/bash
cd leboncoin
php artisan migrate --force 2>&1 | tee /tmp/migrate.log
echo "Starting on port $PORT"
php -S 0.0.0.0:${PORT} -t public 2>&1
