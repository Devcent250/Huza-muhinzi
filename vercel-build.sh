#!/bin/bash

# Copy environment file
cp .env.example .env

# Install Composer dependencies
composer install --no-dev --optimize-autoloader

# Generate application key
php artisan key:generate --force

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Install and build frontend assets
npm install
npm run build