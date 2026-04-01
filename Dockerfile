# Use official PHP + Apache image
FROM php:8.2-apache

# Enable mysqli extension
RUN docker-php-ext-install mysqli

# Copy all files into Apache document root
COPY . /var/www/html/

# Enable mod_rewrite for clean URLs
RUN a2enmod rewrite

# Expose port 10000 (Render uses this internally)
EXPOSE 10000

# Start Apache in foreground
CMD ["apache2-foreground"]