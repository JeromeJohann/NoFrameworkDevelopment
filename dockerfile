# Use the official PHP-FPM image for PHP 8.0
FROM php:8.0-fpm

# Install necessary PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Set the working directory to /var/www
WORKDIR /var/www

# Copy the application files to the container's working directory
COPY app/ /var/www/

# Expose the PHP-FPM port (optional)
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
