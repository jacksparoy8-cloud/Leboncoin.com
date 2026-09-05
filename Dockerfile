FROM php:8.2-fpm

WORKDIR /app

# Install dependencies
RUN apt-get update && apt-get install -y \
    curl \
    git \
    zip \
    unzip \
    sqlite3 \
    libsqlite3-dev \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application
COPY leboncoin /app

# Install PHP dependencies
RUN composer install --no-interaction --optimize-autoloader

# Install Node dependencies
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    npm install && \
    npm run build

# Set permissions
RUN chmod -R 755 storage bootstrap/cache && \
    chmod -R 777 storage bootstrap/cache

# Expose port
EXPOSE 8080

# Start Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
