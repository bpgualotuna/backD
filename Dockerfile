# ── Stage 1: Build dependencies ───────────────────────────────────────────
FROM composer:2.7 AS builder

WORKDIR /app
COPY composer.json composer.lock* ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

# ── Stage 2: Runtime ───────────────────────────────────────────────────────
FROM php:8.2-apache

# Install MongoDB PHP extension
RUN apt-get update && apt-get install -y libssl-dev pkg-config \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite (needed for the PHP router)
RUN a2enmod rewrite

# Set document root
ENV APACHE_DOCUMENT_ROOT /var/www/html

# Copy application source
WORKDIR /var/www/html
COPY --from=builder /app/vendor ./vendor
COPY . .

# Apache virtual host — allow .htaccess overrides
RUN sed -i 's|/var/www/html|/var/www/html|g' /etc/apache2/sites-available/000-default.conf \
    && sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Set permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
CMD ["apache2-foreground"]
