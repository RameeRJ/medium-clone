# Use official PHP 8.2 with extensions
FROM php:8.2-apache

# Enable Apache mod_rewrite for Laravel routes
RUN a2enmod rewrite

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip nodejs npm sqlite3 \
    && docker-php-ext-install pdo pdo_mysql

# Set working directory
WORKDIR /var/www/html

# Copy app files
COPY . .

# Install composer dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# Build frontend assets
RUN npm install && npm run build

# Generate app key
RUN php artisan key:generate

# Set permissions for storage
RUN chmod -R 775 storage bootstrap/cache

# Expose port 80
EXPOSE 80

# Start Laravel using Apache
CMD ["apache2-foreground"]
