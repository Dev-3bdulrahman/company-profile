# Base image
FROM php:8.3-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    oniguruma-dev \
    libxml2-dev \
    icu-dev \
    bash \
    shadow

# Sync www-data UID/GID with host (1000)
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    gd \
    zip \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    xml \
    intl

# 🔥 CONFIGURE PHP-FPM FOR UNIX SOCKET (FIX 502)
RUN echo "listen = /tmp/php-fpm.sock" > /usr/local/etc/php-fpm.d/zz-docker.conf \
    && echo "listen.mode = 0666" >> /usr/local/etc/php-fpm.d/zz-docker.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application code
COPY . .

# Install PHP dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Configure Nginx
COPY nginx.conf /etc/nginx/http.d/default.conf

# Configure Supervisor
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Configure PHP
COPY php.ini /usr/local/etc/php/conf.d/99-custom.ini

# Setup entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port
EXPOSE 3000

# Entrypoint
ENTRYPOINT ["docker-entrypoint.sh"]
