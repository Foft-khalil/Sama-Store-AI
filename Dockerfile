# Use an official PHP image with Apache
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    unzip \
    git \
    nodejs \
    npm \
    && rm -rf /var/lib/apt/lists/*

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_mysql bcmath zip intl

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Change Apache to listen on 8080
RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf
RUN sed -i 's/:80/:8080/' /etc/apache2/sites-available/000-default.conf

# Set the document root to Laravel's public folder
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# Install NPM dependencies and build assets
RUN npm install && npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod +x /var/www/html/docker-entrypoint.sh

# Expose port 8080
EXPOSE 8080

# Use entrypoint
ENTRYPOINT ["/var/www/html/docker-entrypoint.sh"]

# Start Apache
CMD ["apache2-foreground"]
